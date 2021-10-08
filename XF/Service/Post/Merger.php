<?php

namespace ThemeHouse\StaffTracker\XF\Service\Post;

use ThemeHouse\StaffTracker\XF\Entity\Thread;

/**
 * Class Merger
 * @package ThemeHouse\StaffTracker\XF\Service\Post
 */
class Merger extends XFCP_Merger
{
    /**
     *
     */
    protected function updateTargetData()
    {
        /** @var Thread $targetThread */
        $targetThread = $this->target->Thread;

        $targetThread->rebuildThStaffTrackerCache();

        parent::updateTargetData();
    }

    /**
     *
     */
    protected function updateSourceData()
    {
        foreach ($this->sourceThreads as $sourceThread) {
            /** @var Thread $sourceThread */
            $sourceThread->rebuildThStaffTrackerCache();
        }

        parent::updateSourceData();
    }
}
