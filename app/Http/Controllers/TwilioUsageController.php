<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Iterators\Filters\UsageWithCountFilter;
use ArrayIterator;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Twilio\Rest\Api\V2010\Account\Usage\Record\LastMonthInstance;
use Twilio\Rest\Client;

class TwilioUsageController extends Controller
{
    public const DEFAULT_RECORD_LIMIT = 20;
    public const DEFAULT_USAGE_TYPE = 'last_month';

    public function __construct(private readonly Client $twilio) {}

    /**
     * Retrieve and return the user's Twilio account usage information.
     */
    public function __invoke(
        Request $request,
        int $recordLimit = self::DEFAULT_RECORD_LIMIT,
        string $usageType = self::DEFAULT_USAGE_TYPE
    ): View
    {
        $usageRecords = match ($usageType) {
            'all_time' => $this->getAllUsageRecords($recordLimit),
            'today' => $this->getTodaysUsageRecords($recordLimit),
            default => $this->getLastMonthUsageRecords($recordLimit),
        };

        $recordsIterator = new ArrayIterator($usageRecords);
        $recordsIterator->uasort(function ($recordOne, $recordTwo) {
            return ($recordOne->category >= $recordTwo->category);
        });
        $filteredRecords = new UsageWithCountFilter($recordsIterator);

        return view(
            'twilio.account.usage',
            [
                'usageRecords' => $filteredRecords,
                'recordCount' => iterator_count($filteredRecords)
            ]
        );
    }

    /**
     * @param int $recordLimit
     * @return LastMonthInstance[]
     */
    public function getLastMonthUsageRecords(int $recordLimit): array
    {
        return $this->twilio
            ->usage
            ->records
            ->lastMonth
            ->read([], $recordLimit);
    }

    public function getTodaysUsageRecords(int $recordLimit): array
    {
        return $this->twilio
            ->usage
            ->records
            ->today
            ->read([], $recordLimit);
    }

    public function getAllUsageRecords(int $recordLimit): array
    {
        return $this->twilio
            ->usage
            ->records
            ->read([], $recordLimit);
    }
}
