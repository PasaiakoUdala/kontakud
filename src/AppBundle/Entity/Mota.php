<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Mota
 *
 * @ORM\Table(name="mota")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MotaRepository")
 */
class Mota
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
     * @var tramiteak[]
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Tramite", mappedBy="arreta",cascade={"persist"})
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $tramiteak;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->tramiteak = new ArrayCollection();
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
     * @return Mota
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
     * @return Mota
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
     * @return Mota
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
     * @return Mota
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
     * Add tramiteak.
     *
     * @param \AppBundle\Entity\Tramite $tramiteak
     *
     * @return Mota
     */
    public function addTramiteak(\AppBundle\Entity\Tramite $tramiteak)
    {
        $this->tramiteak[] = $tramiteak;

        return $this;
    }

    /**
     * Remove tramiteak.
     *
     * @param \AppBundle\Entity\Tramite $tramiteak
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeTramiteak(\AppBundle\Entity\Tramite $tramiteak)
    {
        return $this->tramiteak->removeElement($tramiteak);
    }

    /**
     * Get tramiteak.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTramiteak()
    {
        return $this->tramiteak;
    }

    /**
     * Set namees.
     *
     * @param string $namees
     *
     * @return Mota
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
