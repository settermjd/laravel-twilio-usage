<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Iterators\Filters\UsageWithCountFilter;
use ArrayIterator;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Twilio\Rest\Client;

class TwilioUsageController extends Controller
{
    public function __construct(private readonly Client $twilio) {}

    /**
     * Retrieve and return the user's Twilio account usage information.
     */
    public function __invoke(Request $request, int $recordLimit): View
    {
        $usageRecords = $this->twilio
            ->usage
            ->records
            ->lastMonth
            ->read([], $recordLimit);

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
}
