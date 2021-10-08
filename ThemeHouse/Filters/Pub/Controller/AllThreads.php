<?php

namespace ThemeHouse\StaffTracker\ThemeHouse\Filters\Pub\Controller;

use XF\Finder\Thread;

/**
 * Class AllThreads
 * @package ThemeHouse\StaffTracker\ThemeHouse\Filters\Pub\Controller
 */
class AllThreads extends XFCP_AllThreads
{
    /**
     * @return array|bool[]
     */
    protected function getFilterInput()
    {
        $filters = parent::getFilterInput();

        if ($this->filter('staff', 'bool')) {
            $filters['staff'] = true;
        }

        return $filters;
    }

    /**
     * @param Thread $threadFinder
     * @param array $filters
     */
    protected function applyFilters(Thread &$threadFinder, array $filters)
    {
        parent::applyFilters($threadFinder, $filters);

        if (!empty($filters['staff']) && $filters['staff']) {
            $threadFinder->where('thstafftracker_staff_post_count', '>', 0);
        }
    }
}
