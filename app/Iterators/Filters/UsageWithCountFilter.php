<?php

declare(strict_types=1);

namespace App\Iterators\Filters;

use Iterator;

class UsageWithCountFilter extends \FilterIterator
{
    public function accept(): bool
    {
        $usageRecord = $this->getInnerIterator()->current();
        return (! empty($usageRecord->count));
    }
}
