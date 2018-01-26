<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Result
 *
 * @ORM\Table(name="result")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ResultRepository")
 */
class Result
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
     * @ORM\Column(name="name", type="string", length=255, unique=true)
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
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Tramite", mappedBy="result",cascade={"persist"})
     * @ORM\OrderBy({"name" = "ASC"})
     */
    private $tramiteak;

    /**
     * Constructor.
     */
    public function __construct()
    {

    }

    public function __toString()
    {
        return $this->getName();
    }

    /*****************************************************************************************************************/
    /*****************************************************************************************************************/
    /*****************************************************************************************************************/



    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return Result
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set created.
     *
     * @param \DateTime $created
     *
     * @return Result
     */
    public function setCreated($created)
    {
        $this->created = $created;

        return $this;
    }

    /**
     * Get created.
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Set updated.
     *
     * @param \DateTime $updated
     *
     * @return Result
     */
    public function setUpdated($updated)
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * Get updated.
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }

    /**
     * Set contentChangedBy.
     *
     * @param string|null $contentChangedBy
     *
     * @return Result
     */
    public function setContentChangedBy($contentChangedBy = null)
    {
        $this->contentChangedBy = $contentChangedBy;

        return $this;
    }

    /**
     * Get contentChangedBy.
     *
     * @return string|null
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
     * @return Result
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
     * @return Result
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
