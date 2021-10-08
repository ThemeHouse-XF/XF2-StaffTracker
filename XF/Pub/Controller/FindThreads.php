<?php

namespace ThemeHouse\StaffTracker\XF\Pub\Controller;

use ThemeHouse\StaffTracker\XF\Repository\Thread;

/**
 * Class FindThreads
 * @package ThemeHouse\StaffTracker\XF\Pub\Controller
 *
 * @method Thread getThreadRepo()
 */
class FindThreads extends XFCP_FindThreads
{
    /**
     * @return \XF\Mvc\Reply\Redirect
     */
    public function actionIndex()
    {
        switch ($this->filter('type', 'str')) {
            case 'staff':
                return $this->redirectPermanently($this->buildLink('find-threads/staff'));
            default:
                return parent::actionIndex();
        }
    }

    /**
     * @return \XF\Mvc\Reply\View
     */
    public function actionStaff()
    {
        $threadFinder = $this->getThreadRepo()->findThreadsWithStaffPosts();

        return $this->getThreadResults($threadFinder, 'staff');
    }
}
