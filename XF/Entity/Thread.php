<?php

namespace ThemeHouse\StaffTracker\XF\Entity;

use XF\Mvc\Entity\Structure;
use XF\Entity\Post;

/**
 * Class Thread
 * @package ThemeHouse\StaffTracker\XF\Entity
 *
 * @property integer thstafftracker_staff_post_count
 * @property integer thstafftracker_adjusted_staff_post_count
 */
class Thread extends XFCP_Thread
{
    /**
     * @param Post $post
     */
    public function postAdded(Post $post)
    {
        if ($post->User && $post->User->is_staff) {
            $this->thstafftracker_staff_post_count++;
        }

        parent::postAdded($post);
    }

    /**
     * @param Post $post
     */
    public function postRemoved(Post $post)
    {
        if ($post->User && $post->User->is_staff) {
            $this->thstafftracker_staff_post_count--;
        }

        parent::postRemoved($post);
    }

    /**
     * @return bool|mixed|null
     */
    public function rebuildThStaffTrackerCache()
    {
        $staffPosts = $this->db()->fetchOne("
            SELECT COUNT(*)
            FROM xf_post AS post
            INNER JOIN xf_user AS user ON (user.user_id = post.user_id)
            WHERE post.thread_id = ?
                AND post.message_state = 'visible'
                AND user.is_staff
        ", $this->thread_id);

        $staffPosts = max(0, $staffPosts);

        if ($staffPosts === $this->thstafftracker_staff_post_count) {
            return false;
        }

        $this->thstafftracker_staff_post_count = $staffPosts;

        return $staffPosts;
    }

    /**
     * @return int|mixed|null
     */
    public function getThStaffTrackerAdjustedStaffPostCount()
    {
        if (!\XF::options()->thstafftracker_includeFirstPost && $this->FirstPost->User && $this->FirstPost->User->is_staff) {
            return $this->thstafftracker_staff_post_count - 1;
        }
        return $this->thstafftracker_staff_post_count;
    }

    /**
     * @param Structure $structure
     * @return Structure
     */
    public static function getStructure(Structure $structure)
    {
        $structure = parent::getStructure($structure);

        $structure->columns['thstafftracker_staff_post_count'] = ['type' => self::UINT, 'default' => 0];

        $structure->getters['thstafftracker_adjusted_staff_post_count'] = true;

        return $structure;
    }
}
