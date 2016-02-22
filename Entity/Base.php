<?php

namespace Skillberto\SonataExtendedAdminBundle\Entity;

/**
 * Base
 */
abstract class Base
{
    /**
     * @var string
     */
    protected $active;

    /**
     * @var \DateTime
     */
    protected $createdAt;

    /**
     * @var \DateTime
     */
    protected $updatedAt;
    
    /**
     * Set active
     *
     * @param string $active
     * @return Base
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return string 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Base
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Base
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @ORM\PrePersist
     */
    public function createdAt()
    {
        $this->setCreatedAt( new \DateTime("now") );
    }

    /**
     * @ORM\PostPersist
     */
    public function updateAt()
    {
        $this->setUpdatedAt( new \DateTime("now") );
    }

}
