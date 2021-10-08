<?php

namespace ThemeHouse\StaffTracker\XF\Service\Thread;

/**
 * Class Merger
 * @package ThemeHouse\StaffTracker\XF\Service\Thread
 *
 * @property \ThemeHouse\StaffTracker\XF\Entity\Thread target
 */
class Merger extends XFCP_Merger
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
}
