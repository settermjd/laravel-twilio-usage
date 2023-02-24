<?php

declare(strict_types=1);

namespace App\Iterators\Filters;

use Iterator;

class UsageWithCountFilter extends \FilterIterator implements \Countable
{
    public function accept(): bool
    {
        $usageRecord = $this->getInnerIterator()->current();
        return (! empty($usageRecord->count));
    }

    public function count(): int
    {
        return iterator_count($this->getInnerIterator());
    }
}
