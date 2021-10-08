<?php

namespace ThemeHouse\StaffTracker\XF\Job;

/**
 * Class Thread
 * @package ThemeHouse\StaffTracker\XF\Job
 */
class Thread extends XFCP_Thread
{
    /**
     * @param array $data
     * @return array
     */
    protected function setupData(array $data)
    {
        $defaultData = [
            'thstafftracker_rebuild' => true,
        ];

        $this->defaultData = array_merge($this->defaultData, $defaultData);

        return parent::setupData($data);
    }

    /**
     * @param $id
     * @throws \XF\PrintableException
     */
    protected function rebuildById($id)
    {
        parent::rebuildById($id);

        if ($this->data['thstafftracker_rebuild']) {
            /** @var \XF\Entity\Thread $thread */
            /** @var \ThemeHouse\StaffTracker\XF\Entity\Thread $thread */
            $thread = \XF::em()->find('XF:Thread', $id);
            if (!$thread) {
                return;
            }

            if ($thread->rebuildThStaffTrackerCache()) {
                $thread->save();
            }
        }
    }
}
