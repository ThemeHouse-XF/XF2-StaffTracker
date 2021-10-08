<?php

namespace ThemeHouse\StaffTracker\XF\Service\Post;

/**
 * Class Copier
 * @package ThemeHouse\StaffTracker\XF\Service\Post
 *
 * @property \ThemeHouse\StaffTracker\XF\Entity\Thread target
 */
class Copier extends XFCP_Copier
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
