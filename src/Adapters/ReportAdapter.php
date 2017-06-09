<?php

namespace Brainfab\Toggl\Adapters;

use Brainfab\Toggl\Entities\ReportDetails;
use Brainfab\Toggl\Entities\ReportSummary;
use Brainfab\Toggl\Entities\ReportWeekly;

/**
 * Class ReportAdapter.
 */
class ReportAdapter
{
    /**
     * Transform API result to entity object.
     *
     * @param array $data API result.
     *
     * @return ReportDetails
     */
    public function transformDetails(array $data, ReportDetails $object = null)
    {
        if (null === $object) {
            $object = new ReportDetails();
        }

        return $object;
    }

    /**
     * Transform API result to entity object.
     *
     * @param array $data API result.
     *
     * @return ReportSummary
     */
    public function transformSummary(array $data, ReportSummary $object = null)
    {
        if (null === $object) {
            $object = new ReportSummary();
        }

        return $object;
    }

    /**
     * Transform API result to entity object.
     *
     * @param array $data API result.
     *
     * @return ReportWeekly
     */
    public function transformWeekly(array $data, ReportWeekly $object = null)
    {
        if (null === $object) {
            $object = new ReportWeekly();
        }

        return $object;
    }
}
