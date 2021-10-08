<?php

namespace ThemeHouse\StaffTracker\XF\Entity;

/**
 * Class User
 * @package ThemeHouse\StaffTracker\XF\Entity
 */
class User extends XFCP_User
{
    /**
     *
     */
    protected function _postSave()
    {
        if (!$this->isInsert() && $this->isChanged('is_staff')) {
            $this->app()->jobManager()->enqueue('XF:Thread');
        }

        parent::_postSave();
    }
}
