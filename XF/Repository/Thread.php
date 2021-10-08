<?php

namespace ThemeHouse\StaffTracker\XF\Repository;

/**
 * Class Thread
 * @package ThemeHouse\StaffTracker\XF\Repository
 */
class Thread extends XFCP_Thread
{
    /**
     * @return mixed
     */
    public function findThreadsWithStaffPosts()
    {
        /** @var \XF\Finder\Thread $finder */
        $finder = $this->finder('XF:Thread');

        $finder
        ->with('full')
        ->with(['Forum', 'User'])
        ->where('discussion_type', '<>', 'redirect')
        ->order('last_post_date', 'DESC')
        ->indexHint('FORCE', 'last_post_date');

        if (!\XF::options()->thstafftracker_includeFirstPost) {
            $finder->whereOr([
                [
                    ['thstafftracker_staff_post_count', '>', 1],
                ],
                [
                    ['thstafftracker_staff_post_count', '=', 1],
                    ['FirstPost.User.is_staff', '=', 0],
                ],
            ]);
        } else {
            $finder->where('thstafftracker_staff_post_count', '>', 0);
        }

        $addOns = \XF::app()->registry()['addOns'];

        if (isset($addOns['ThemeHouse/Topics'])) {
            if (\XF::options()->thtopics_enableTopics) {
                $finder->with('Topic');
            }

            if (\XF::options()->thtopics_topicFilterFindThreadsPages) {
                /** @noinspection PhpUndefinedMethodInspection */
                $finder->filterByTopicsAndForums();
            }
        }

        return $finder;
    }
}
