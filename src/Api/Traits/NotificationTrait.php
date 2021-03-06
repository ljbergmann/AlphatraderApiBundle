<?php

namespace Alphatrader\ApiBundle\Api\Traits;

use Alphatrader\ApiBundle\Api\Methods\NotificationController;

/**
 * Class NotificationTrait
 *
 * @package Alphatrader\ApiBundle\Api\Traits
 * @author  Tr0nYx
 */
trait NotificationTrait
{
    /**
     * @return mixed
     */
    public function setNotificationsasRead()
    {
        return $this->getNotificationsController()->markAsRead();
    }

    /**
     * @return \Alphatrader\ApiBundle\Model\Notifications[]
     */
    public function getNotifications()
    {
        return $this->getNotificationsController()->getNotifications();
    }

    /**
     * @return \Alphatrader\ApiBundle\Model\Notifications[]|\Alphatrader\ApiBundle\Model\Error
     */
    public function getUnreadNotifications()
    {
        return $this->getNotificationsController()->getUnreadNotifications();
    }
    
    /**
     * @return NotificationController
     */
    public function getNotificationsController()
    {
        return new NotificationController($this->config, $this->jwt);
    }
}
