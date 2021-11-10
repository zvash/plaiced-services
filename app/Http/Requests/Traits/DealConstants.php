<?php

namespace App\Http\Requests\Traits;

use App\Models\Deal;
use Illuminate\Validation\Rule;

trait DealConstants
{
    /**
     * Get ownership type in rule.
     *
     * @return string
     */
    protected function getOwnershipType()
    {
        return (string) Rule::in([
            Deal::OWNERSHIP_TYPE_KEEP,
            Deal::OWNERSHIP_TYPE_LOAN
        ]);
    }

    /**
     * Get exposure expectation in rule.
     *
     * @return string
     */
    protected function getExposureExpectations()
    {
        return (string) Rule::in([
            Deal::EXPOSURE_EXPECTATIONS_MANDATORY,
            Deal::EXPOSURE_EXPECTATIONS_FLEXIBLE
        ]);
    }

    /**
     * Get deal statuses in rule.
     *
     * @return string
     */
    protected function getStatuses()
    {
        return (string) Rule::in(Deal::getStatuses());
    }
}
