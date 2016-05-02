<?php

namespace EntitiesBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Users
 */
class Users
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $nickname;

    /**
     * @var string
     */
    private $email;

    /**
     * @var string
     */
    private $password;


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
     * Set nickname
     *
     * @param string $nickname
     * @return Users
     */
    public function setNickname($nickname)
    {
        $this->nickname = $nickname;

        return $this;
    }

    /**
     * Get nickname
     *
     * @return string 
     */
    public function getNickname()
    {
        return $this->nickname;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Users
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     * @return Users
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }
    /**
     * @var string
     */
    private $profileImageUrl;

    /**
     * @var \DateTime
     */
    private $birthDate;


    /**
     * Set profileImageUrl
     *
     * @param string $profileImageUrl
     * @return Users
     */
    public function setProfileImageUrl($profileImageUrl)
    {
        $this->profileImageUrl = $profileImageUrl;

        return $this;
    }

    /**
     * Get profileImageUrl
     *
     * @return string 
     */
    public function getProfileImageUrl()
    {
        return $this->profileImageUrl;
    }

    /**
     * Set birthDate
     *
     * @param \DateTime $birthDate
     * @return Users
     */
    public function setBirthDate($birthDate)
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    /**
     * Get birthDate
     *
     * @return \DateTime 
     */
    public function getBirthDate()
    {
        return $this->birthDate;
    }
    /**
     * @var \Doctrine\Common\Collections\Collection
     */
    private $features;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->features = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add features
     *
     * @param \EntitiesBundle\Entity\users $features
     * @return Users
     */
    public function addFeature(\EntitiesBundle\Entity\users $features)
    {
        $this->features[] = $features;

        return $this;
    }

    /**
     * Remove features
     *
     * @param \EntitiesBundle\Entity\users $features
     */
    public function removeFeature(\EntitiesBundle\Entity\users $features)
    {
        $this->features->removeElement($features);
    }

    /**
     * Get features
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFeatures()
    {
        return $this->features;
    }
}
