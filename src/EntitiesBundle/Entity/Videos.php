<?php

namespace EntitiesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Videos
 */
class Videos
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $video_name;

    /**
     * @var string
     */
    private $description;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set url
     *
     * @param string $url
     * @return Videos
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set video_name
     *
     * @param string $videoName
     * @return Videos
     */
    public function setVideoName($videoName)
    {
        $this->video_name = $videoName;

        return $this;
    }

    /**
     * Get video_name
     *
     * @return string 
     */
    public function getVideoName()
    {
        return $this->video_name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Videos
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }
    /**
     * @var integer
     */
    private $youtube_id;


    /**
     * Set youtube_id
     *
     * @param integer $youtubeId
     * @return Videos
     */
    public function setYoutubeId($youtubeId)
    {
        $this->youtube_id = $youtubeId;

        return $this;
    }

    /**
     * Get youtube_id
     *
     * @return integer 
     */
    public function getYoutubeId()
    {
        return $this->youtube_id;
    }

    /**
     * @var \EntitiesBundle\Entity\Users
     */
    private $users_id;


    /**
     * Set users_id
     *
     * @param \EntitiesBundle\Entity\Users $usersId
     * @return Videos
     */
    public function setUsersId(\EntitiesBundle\Entity\Users $usersId = null)
    {
        $this->users_id = $usersId;

        return $this;
    }

    /**
     * Get users_id
     *
     * @return \EntitiesBundle\Entity\Users
     */
    public function getUsersId()
    {
        return $this->users_id;
    }
    /**
     * @var \DateTime
     */
    private $video_date;


    /**
     * Set video_date
     *
     * @param \DateTime $videoDate
     * @return Videos
     */
    public function setVideoDate($videoDate)
    {
        $this->video_date = $videoDate;

        return $this;
    }

    /**
     * Get video_date
     *
     * @return \DateTime 
     */
    public function getVideoDate()
    {
        return $this->video_date;
    }
    /**
     * @var string
     */
    private $video_views;


    /**
     * Set video_views
     *
     * @param string $videoViews
     * @return Videos
     */
    public function setVideoViews($videoViews)
    {
        $this->video_views = $videoViews;

        return $this;
    }

    /**
     * Get video_views
     *
     * @return string 
     */
    public function getVideoViews()
    {
        return $this->video_views;
    }
}
