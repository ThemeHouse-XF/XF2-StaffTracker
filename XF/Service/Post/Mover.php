<?php

namespace ThemeHouse\StaffTracker\XF\Service\Post;

use ThemeHouse\StaffTracker\XF\Entity\Thread;

/**
 * Class Mover
 * @package ThemeHouse\StaffTracker\XF\Service\Post
 *
 * @property \ThemeHouse\StaffTracker\XF\Entity\Thread target
 */
class Mover extends XFCP_Mover
{
    /**
     *
     */
    protected function updateTargetData()
    {
        $target = $this->target;

        $target->rebuildThStaffTrackerCache();

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
