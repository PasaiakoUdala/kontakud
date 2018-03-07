<?php

/*
 *     Iker Ibarguren <@ikerib>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use FR3D\LdapBundle\Model\LdapUserInterface;
use JMS\Serializer\Annotation\ExclusionPolicy;
use JMS\Serializer\Annotation\Expose;

/**
 * User.
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 * @ExclusionPolicy("all")
 */
class User extends BaseUser implements LdapUserInterface
{
    /**
     * @var int
     * @Expose
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     */
    protected $dn;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $department;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $displayname;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $nan;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $hizkuntza;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $lanpostua;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $notes;

    /**
     * @ORM\Column(type="json_array", nullable=true)
     */
    private $members = [];

    /*****************************************************************************************************************/
    /*** ERLAZIOAK ***************************************************************************************************/
    /*****************************************************************************************************************/

    /**
     * @var arretak[]
     *
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Arreta", mappedBy="user",cascade={"persist"})
     * @ORM\OrderBy({"fetxa" = "ASC"})
     */
    private $arretak;

    /**
     * @var \AppBundle\Entity\Barrutia
     *
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Barrutia", inversedBy="users")
     * @ORM\JoinColumn(name="barrutia_id", referencedColumnName="id",onDelete="CASCADE")
     */
    private $barrutia;

    /**
     * Constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->members = [];

        if (empty($this->roles)) {
            $this->roles[] = 'ROLE_USER';
        }
        $this->arretak = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getUsername();
    }

    /*****************************************************************************************************************/
    /*****************************************************************************************************************/
    /*****************************************************************************************************************/



    public function getMembers()
    {
        return $this->members;
    }

    public function setMembers(array $members)
    {
        $this->members = $members;

        // allows for chaining
        return $this;
    }

    /**
     * Set Ldap Distinguished Name.
     *
     * @param string $dn Distinguished Name
     */
    public function setDn($dn)
    {
        $this->dn = $dn;
    }

    /**
     * Get Ldap Distinguished Name.
     *
     * @return null|string Distinguished Name
     */
    public function getDn()
    {
        return $this->dn;
    }


    /**
     * Set department.
     *
     * @param string $department
     *
     * @return User
     */
    public function setDepartment($department)
    {
        $this->department = $department;

        return $this;
    }

    /**
     * Get department.
     *
     * @return string
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * Set displayname.
     *
     * @param string $displayname
     *
     * @return User
     */
    public function setDisplayname($displayname)
    {
        $this->displayname = $displayname;

        return $this;
    }

    /**
     * Get displayname.
     *
     * @return string
     */
    public function getDisplayname()
    {
        return $this->displayname;
    }

    /**
     * Set nan.
     *
     * @param string $nan
     *
     * @return User
     */
    public function setNan($nan)
    {
        $this->nan = $nan;

        return $this;
    }

    /**
     * Get nan.
     *
     * @return string
     */
    public function getNan()
    {
        return $this->nan;
    }

    /**
     * Set lanpostua.
     *
     * @param string $lanpostua
     *
     * @return User
     */
    public function setLanpostua($lanpostua)
    {
        $this->lanpostua = $lanpostua;

        return $this;
    }

    /**
     * Get lanpostua.
     *
     * @return string
     */
    public function getLanpostua()
    {
        return $this->lanpostua;
    }




    /**
     * Set notes
     *
     * @param string $notes
     *
     * @return User
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;

        return $this;
    }

    /**
     * Get notes
     *
     * @return string
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * Add arretak.
     *
     * @param \AppBundle\Entity\Arreta $arretak
     *
     * @return User
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
     * Set barrutia.
     *
     * @param string|null $barrutia
     *
     * @return User
     */
    public function setBarrutia($barrutia = null)
    {
        $this->barrutia = $barrutia;

        return $this;
    }

    /**
     * Get barrutia.
     *
     * @return string|null
     */
    public function getBarrutia()
    {
        return $this->barrutia;
    }

    /**
     * Set hizkuntza.
     *
     * @param string|null $hizkuntza
     *
     * @return User
     */
    public function setHizkuntza($hizkuntza = null)
    {
        $this->hizkuntza = $hizkuntza;

        return $this;
    }

    /**
     * Get hizkuntza.
     *
     * @return string|null
     */
    public function getHizkuntza()
    {
        return $this->hizkuntza;
    }
}
