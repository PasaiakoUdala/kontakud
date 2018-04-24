<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Barrutia
 *
 * @ORM\Table(name="barrutia")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BarrutiaRepository")
 */
class Barrutia
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


    /*****************************************************************************************************************/
    /*** ERLAZIOAK ***************************************************************************************************/
    /*****************************************************************************************************************/

    /**
     * @var users[]
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\User", mappedBy="barrutia",cascade={"persist"})
     */
    private $users;

    /**
     * @var arretak[]
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Arreta", mappedBy="sacbarrutia",cascade={"persist"})
     * @ORM\OrderBy({"fetxa" = "ASC"})
     */
    private $arretak;

    public function __construct()
    {
        $this->users = new ArrayCollection();
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
     * @return Barrutia
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
     * Add user.
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return Barrutia
     */
    public function addUser(\AppBundle\Entity\User $user)
    {
        $this->users[] = $user;

        return $this;
    }

    /**
     * Remove user.
     *
     * @param \AppBundle\Entity\User $user
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeUser(\AppBundle\Entity\User $user)
    {
        return $this->users->removeElement($user);
    }

    /**
     * Get users.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Add arretak.
     *
     * @param \AppBundle\Entity\Arreta $arretak
     *
     * @return Barrutia
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
}
