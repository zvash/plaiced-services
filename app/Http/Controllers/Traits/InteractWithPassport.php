<?php

namespace App\Http\Controllers\Traits;

use App\Models\User;
use DateTimeImmutable;
use GuzzleHttp\Psr7\Response;
use Illuminate\Events\Dispatcher;
use Laravel\Passport\Bridge\AccessToken;
use Laravel\Passport\Bridge\AccessTokenRepository;
use Laravel\Passport\Bridge\Client;
use Laravel\Passport\Bridge\ClientRepository;
use Laravel\Passport\Client as ClientModel;
use Laravel\Passport\ClientRepository as ClientModelRepository;
use Laravel\Passport\Bridge\RefreshTokenRepository;
use Laravel\Passport\Passport;
use Laravel\Passport\TokenRepository;
use League\OAuth2\Server\CryptKey;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\RefreshTokenEntityInterface;
use League\OAuth2\Server\Exception\OAuthServerException;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;
use League\OAuth2\Server\ResponseTypes\BearerTokenResponse;

trait InteractWithPassport
{
    /**
     * Generate a new unique identifier.
     *
     * @param  int  $length
     * @return string
     *
     * @throws \League\OAuth2\Server\Exception\OAuthServerException
     */
    private function generateUniqueIdentifier($length = 40)
    {
        try {
            return bin2hex(random_bytes($length));
        } catch (\TypeError $e) {
            throw OAuthServerException::serverError('An unexpected error has occurred');
        } catch (\Error $e) {
            throw OAuthServerException::serverError('An unexpected error has occurred');
        } catch (\Exception $e) {
            throw OAuthServerException::serverError('Could not generate a random string');
        }
    }

    /**
     * Generate a new refresh Token.
     *
     * @param  \League\OAuth2\Server\Entities\AccessTokenEntityInterface  $accessToken
     * @return \Laravel\Passport\Bridge\RefreshToken
     *
     * @throws \League\OAuth2\Server\Exception\OAuthServerException
     * @throws \League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException
     */
    private function issueRefreshToken(AccessTokenEntityInterface $accessToken)
    {
        $maxGenerationAttempts = 10;
        $refreshTokenRepository = app(RefreshTokenRepository::class);

        $refreshToken = $refreshTokenRepository->getNewRefreshToken();
        $refreshToken->setExpiryDateTime((new DateTimeImmutable())->add(Passport::refreshTokensExpireIn()));
        $refreshToken->setAccessToken($accessToken);

        while ($maxGenerationAttempts-- > 0) {
            $refreshToken->setIdentifier($this->generateUniqueIdentifier());
            try {
                $refreshTokenRepository->persistNewRefreshToken($refreshToken);

                return $refreshToken;
            } catch (UniqueTokenIdentifierConstraintViolationException $e) {
                if ($maxGenerationAttempts === 0) {
                    throw $e;
                }
            }
        }
    }

    /**
     * Create passport token by user.
     *
     * @param  \App\Models\User  $user
     * @return array
     *
     * @throws \League\OAuth2\Server\Exception\OAuthServerException
     * @throws \League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException
     */
    protected function createPassportTokenByUser(User $user)
    {
        $passportClient = ClientModel::where('password_client', 1)->first();
        $clientModelRepository = new ClientModelRepository();
        $clientRepository = new ClientRepository($clientModelRepository);
        $client = $clientRepository->getClientEntity($passportClient->id);

        $accessToken = new AccessToken($user->id, [], $client);
        $accessToken->setIdentifier($this->generateUniqueIdentifier());
        $accessToken->setClient(new Client($passportClient->id, null, null));
        $accessToken->setExpiryDateTime((new DateTimeImmutable())->add(Passport::tokensExpireIn()));

        $accessTokenRepository = new AccessTokenRepository(new TokenRepository(), new Dispatcher());
        $accessTokenRepository->persistNewAccessToken($accessToken);
        $refreshToken = $this->issueRefreshToken($accessToken);

        return [
            'access_token' => $accessToken,
            'refresh_token' => $refreshToken,
        ];
    }

    /**
     * Send bearer token response.
     *
     * @param  \League\OAuth2\Server\Entities\AccessTokenEntityInterface  $accessToken
     * @param  \League\OAuth2\Server\Entities\RefreshTokenEntityInterface  $refreshToken
     * @return \Psr\Http\Message\ResponseInterface
     */
    protected function sendBearerTokenResponse(AccessTokenEntityInterface $accessToken, RefreshTokenEntityInterface $refreshToken)
    {
        $privateKey = new CryptKey('file://'.Passport::keyPath('oauth-private.key'));
        $response = new BearerTokenResponse();

        $accessToken->setPrivateKey($privateKey);

        $response->setAccessToken($accessToken);
        $response->setRefreshToken($refreshToken);
        $response->setPrivateKey($privateKey);
        $response->setEncryptionKey(app('encrypter')->getKey());

        return $response->generateHttpResponse(new Response);
    }

    /**
     * Get bearer token by user.
     *
     * @param  \App\Models\User  $user
     * @param  bool  $output
     * @return array|\League\OAuth2\Server\ResponseTypes\BearerTokenResponse
     */
    protected function getBearerTokenByUser(User $user, bool $output = true)
    {
        $passportToken = $this->createPassportTokenByUser($user);
        $bearerToken = $this->sendBearerTokenResponse($passportToken['access_token'], $passportToken['refresh_token']);

        if (! $output) {
            return json_decode($bearerToken->getBody()->__toString(), true);
        }

        return $bearerToken;
    }

    /**
     * Login user without password.
     *
     * @param  \App\Models\User  $user
     * @return array|\League\OAuth2\Server\ResponseTypes\BearerTokenResponse
     */
    protected function logUserInWithoutPassword(User $user)
    {
        return $this->getBearerTokenByUser($user, false);
    }
}
