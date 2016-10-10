<?php

namespace Alphatrader\ApiBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\Annotation;

/**
 * Class Chat
 * @package Alphatrader\ApiBundle\Model
 * @Annotation\ExclusionPolicy("none")
 */
class Chat
{
    /**
     * @Annotation\Type("string")
     * @Annotation\SerializedName("id")
     */
    protected $id;

    /**
     * @Annotation\Type("Alphatrader\ApiBundle\Model\LastMessage")
     * @Annotation\SerializedName("lastMessage")
     */
    protected $lastMessage;

    /**
     * @Annotation\Type("string")
     * @Annotation\SerializedName("dateCreated")
     */
    protected $dateCreated;

    /**
     * @Annotation\Type("string")
     * @Annotation\SerializedName("chatName")
     */
    protected $chatName;

    /**
     * @var ArrayCollection<UserName>
     * @Annotation\Type("ArrayCollection<Alphatrader\ApiBundle\Model\UserName>")
     * @Annotation\SerializedName("participants")
     */
    protected $participants;

    /**
     * @Annotation\Type("boolean")
     * @Annotation\SerializedName("readonly")
     */
    protected $readonly;

    /**
     * @var UserName
     * @Annotation\Type("Alphatrader\ApiBundle\Model\UserName")
     * @Annotation\SerializedName("owner")
     */
    protected $owner;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getChatName()
    {
        return $this->chatName;
    }

    /**
     * @param string $chatName
     */
    public function setChatName($chatName)
    {
        $this->chatName = $chatName;
    }

    /**
     * @return string
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * @param string $dateCreated
     */
    public function setDateCreated($dateCreated)
    {
        $this->dateCreated = $dateCreated;
    }

    /**
     * @return LastMessage
     */
    public function getLastMessage()
    {
        return $this->lastMessage;
    }

    /**
     * @param LastMessage $lastMessage
     */
    public function setLastMessage($lastMessage)
    {
        $this->lastMessage = $lastMessage;
    }

    /**
     * @return UserName
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param UserName $owner
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    /**
     * @return UserName[]
     */
    public function getParticipants()
    {
        return $this->participants;
    }

    /**
     * @param UserName[] $participants
     */
    public function setParticipants($participants)
    {
        $this->participants = $participants;
    }

    /**
     * @return boolean
     */
    public function isReadonly()
    {
        return $this->readonly;
    }

    /**
     * @param boolean $readonly
     */
    public function setReadonly($readonly)
    {
        $this->readonly = $readonly;
    }

    /**
     * @SuppressWarnings("unused")
     * @Annotation\PostDeserialize
     */
    private function afterDeserialization()
    {
        if ($this->dateCreated != null) {
            $dateCreated = substr($this->dateCreated, 0, 10) . '.' . substr($this->dateCreated, 10);
            $micro = sprintf("%06d", ($dateCreated - floor($dateCreated)) * 1000000);
            $date = new \DateTime(date('Y-m-d H:i:s.' . $micro, $dateCreated));
            $this->dateCreated = $date;
        }
    }
}
