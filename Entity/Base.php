<?php
namespace Skillberto\AdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Base
 *
 * @ORM\MappedSuperclass
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Entity(repositoryClass="Skillberto\AdminBundle\Entity\Repository\BaseRepository")
 */
abstract class Base
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $locale;
    
    /**
     * @ORM\Column(type="boolean", options={"default":TRUE})
     */
    protected $active = TRUE;
  
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $position;
    
    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $updatedAt;
        
    /**
     * Return value for sonata and other object
     * 
     * @return type
     */
    public function __toString()
    {        
        if (method_exists($this, "getName")) {
            $return = $this->getName()?:"";
        } else {
            $return = $this->getId()?:0;
        }
        
        return $return;
    }
    
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
     * Set locale
     *
     * @param string $locale
     * @return Test
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;

        return $this;
    }

    /**
     * Get locale
     *
     * @return string 
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Menu
     */
    public function setActive($active)
    {
        $this->active = $active;
    
        return $this;
    }    

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }
    
    /**
     * Set position
     *
     * @param integer $position
     * @return Menu
     */
    public function setPosition($position)
    {
        $this->position = $position;
    
        return $this;
    }

    /**
     * Get position
     *
     * @return integer 
     */
    public function getPosition()
    {
        return $this->position;
    }
    
    /**
     * Sets the creation date
     *
     * @ORM\PrePersist
     * 
     * @param \DateTime|null $createdAt
     */
    public function setCreatedAt(\DateTime $createdAt = null)
    {
        $this->createdAt = empty($createdAt) ? $createdAt : new \DateTime("now");;
        
        return $this;
    }

    /**
     * Returns the creation date
     *
     * @return \DateTime|null
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Sets the last update date
     *
     * @ORM\PostPersist
     * 
     * @param \DateTime|null $updatedAt
     */
    public function setUpdatedAt(\DateTime $updatedAt = null)
    {
        $this->updatedAt = empty($updatedAt) ? $updatedAt : new \DateTime("now");
        
        return $this;
    }

    /**
     * Returns the last update date
     *
     * @return \DateTime|null
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
}
