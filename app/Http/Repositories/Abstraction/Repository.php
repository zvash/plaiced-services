<?php

namespace App\Http\Repositories\Abstraction;

use Exception;
use Illuminate\Database\DatabaseManager as Database;

class Repository
{
    /**
     * Database manager object.
     *
     * @var \Illuminate\Database\DatabaseManager
     */
    protected $database;

    /**
     * Repository constructor.
     *
     * @param  \Illuminate\Database\DatabaseManager  $database
     * @return void
     */
    public function __construct(Database $database)
    {
        $this->database = $database;
    }

    /**
     * Wrap a callback execution in a database transaction.
     *
     * @param callable $callback
     * @param mixed ...$arguments
     * @return mixed
     *
     * @throws \Throwable
     */
    public function transaction(callable $callback, ...$arguments)
    {
        try {
            $this->database->beginTransaction();

            $response = $callback(...$arguments);

            $this->database->commit();

            return $response;
        } catch (Exception $exception) {
            $this->database->rollBack();

            throw $exception;
        }
    }
}
