<?php

declare(strict_types=1);

namespace App\Stub\Collection;

class ReplaceIterator
{
    /**
     * Search and replace needle in collection using recursive iteration
     *
     * @param ArrayCollection $haystack
     * @param string $needle
     * @param string $value
     * @return ArrayCollection
     */
    public function replace(ArrayCollection $haystack, string $needle, string $value): ArrayCollection
    {
        $iterator = $haystack->getIterator();

        while ($iterator->valid()) {
            $current = $iterator->current();

            if ($current === $needle) {
                $haystack->offsetSet($iterator->key(), $value);

                return $haystack;
            }

            if (is_array($current)) {
                $collection = new ArrayCollection($current);

                $haystack->offsetSet($iterator->key(), $this->replace($collection, $needle, $value)->data);
            }

            $iterator->next();
        }

        return $haystack;
    }
}
