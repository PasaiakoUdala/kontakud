<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Kanala
 *
 * @ORM\Table(name="kanala")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\KanalaRepository")
 */
class Kanala
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="namees", type="string", length=255)
     */
    private $namees;


    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updated;

    /**
     * @var string
     *
     * @ORM\Column(nullable=true)
     * @Gedmo\Blameable(on="change", field={"title", "body"})
     */
    private $contentChangedBy;

    /*****************************************************************************************************************/
    /*** ERLAZIOAK ***************************************************************************************************/
    /*****************************************************************************************************************/

    /**
     * @var arretak[]
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Arreta", mappedBy="arreta",cascade={"persist"})
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $arretak;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->arretak = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getName();
    }

    /*****************************************************************************************************************/
    /*****************************************************************************************************************/
    /*****************************************************************************************************************/


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
     * Set name
     *
     * @param string $name
     *
     * @return Kanala
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     *
     * @return Kanala
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated
     *
     * @param \DateTime $updated
     *
     * @return Kanala
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set contentChangedBy
     *
     * @param string $contentChangedBy
     *
     * @return Kanala
     */
    public function setContentChangedBy($contentChangedBy)
    {
        $this->contentChangedBy = $contentChangedBy;

        return $this;
    }

    /**
     * Get contentChangedBy
     *
     * @return string
     */
    public function getContentChangedBy()
    {
        return $this->contentChangedBy;
    }

    /**
     * Add arretak.
     *
     * @param \AppBundle\Entity\Arreta $arretak
     *
     * @return Kanala
     */
    public function addArretak(\AppBundle\Entity\Arreta $arretak)
    {
        $this->arretak[] = $arretak;

        return $this;
    }

    /**
     * Remove arretak.
     *
     * @param \AppBundle\Entity\Arreta $arretak
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeArretak(\AppBundle\Entity\Arreta $arretak)
    {
        return $this->arretak->removeElement($arretak);
    }

    /**
     * Get arretak.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getArretak()
    {
        return $this->arretak;
    }

    /**
     * Set namees.
     *
     * @param string $namees
     *
     * @return Kanala
     */
    public function setNamees($namees)
    {
        $this->namees = $namees;

        return $this;
    }

    /**
     * Get namees.
     *
     * @return string
     */
    public function getNamees()
    {
        return $this->namees;
    }
}
