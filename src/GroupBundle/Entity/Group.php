<?php

namespace GroupBundle\Entity;

use FOS\UserBundle\Model\Group as BaseGroup;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use UsersBundle\Entity\User;

/**
 * GroupBundle\Entity\Group
 *
 * @ORM\Entity(repositoryClass="GroupBundle\Entity\Repository\GroupRepository")
 * @ORM\Table(name="groups")
 */
class Group extends BaseGroup
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="secret_key", type="string", length=255)
     */
    protected $secretKey;

    /**
     * @ORM\ManyToMany(targetEntity="\UsersBundle\Entity\User", mappedBy="groups", cascade={"all"})
     */
    protected $users;

    /**
    * Constructor
    */
    public function __construct()
    {
        $this->users                = new ArrayCollection();
    }

    /**
     * Set the value of id.
     *
     * @param integer $id
     * @return \GroupBundle\Entity\Group
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    public function getSecretKey()
    {
        return $this->secretKey;
    }

    public function setSecretKey($secretKey)
    {
        $this->secretKey = $secretKey;
        return $this;
    }

    /* -------------------- Manage users ------------------------- */
    public function addUser(User $user)
    {
        if (!$this->users->contains($user)) {
            $user->addGroup($this);
            $this->users[] = $user;
        }

        return $this;
    }

    public function getUsers()
    {
        return $this->users;
    }

    public function setUsers(ArrayCollection $users)
    {
        $this->users = $users;

        return $this;
    }

    /**
     * Remove users
     *
     * @param \UsersBundle\Entity\User $users
     */
    public function removeUser(User $user)
    {
        //$user->removeGroup($this);
        $this->users->removeElement($user);
    }
}