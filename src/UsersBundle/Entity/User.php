<?php

namespace UsersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

use Symfony\Component\HttpFoundation\File\MimeType\ExtensionGuesser;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Security\Core\User\AdvancedUserInterface;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use GroupBundle\Entity\Group;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * UsersBundle\Entity\User
 *
 * @ORM\Entity(repositoryClass="UsersBundle\Entity\Repository\UserRepository")
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="users")
 * @UniqueEntity(fields="username", message="Login already in use.")
 * @UniqueEntity(fields="email", message="Email already in use.")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id",type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    protected $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    protected $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    protected $img;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\File(
     *     maxSize = "10000M",
     *     mimeTypes = {"image/jpeg", "image/gif", "image/png", "image/jpg"},
     *     mimeTypesMessage = "Le fichier choisi ne correspond pas à un fichier valide",
     *     notFoundMessage = "Le fichier n'a pas été trouvé sur le disque",
     *     uploadErrorMessage = "Erreur dans l'upload du fichier"
     * )
     */
    protected $avatar;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $date_create;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $date_update;

    /**
     * @ORM\ManyToMany(targetEntity="GroupBundle\Entity\Group", inversedBy="users")
     * @ORM\JoinTable(name="users_groups",
     *      joinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="group_id", referencedColumnName="id")}
     * )
     */
    protected $groups;
    
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->date_create = new \DateTime();
        $this->groups = new ArrayCollection();
    }

    /**
     * Set the value of id.
     *
     * @param integer $id
     * @return \UsersBundle\Entity\User
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

    /**
     * Set the value of lastname.
     *
     * @param string $lastname
     * @return \UsersBundle\Entity\User
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get the value of lastname.
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set the value of firstname.
     *
     * @param string $firstname
     * @return \UsersBundle\Entity\User
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get the value of firstname.
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Get the value of img.
     *
     * @return string
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * Set the value of avatar.
     *
     * @param string $avatar
     * @return \UsersBundle\Entity\User
     */
    public function setAvatar(UploadedFile $avatar)
    {
        if (null === $avatar) {
            return $this ;
        }

        $name_file = $this->getNameFile($avatar) ;

        $avatar->move($this->getUploadRootDir(), $name_file);

        $this->avatar = $this->getUploadRootDir().'/'.$name_file;

        return $this ;
    }

    /**
     * Get the value of avatar.
     *
     * @return string
     */
    public function getAvatar()
    {
        return $this->avatar;
    }

    /**
     * Set the value of date_create.
     *
     * @param integer $date_create
     * @return \UsersBundle\Entity\User
     */
    public function setDateCreate($date_create)
    {
        $this->date_create = $date_create;

        return $this;
    }

    /**
     * Get the value of date_create.
     *
     * @return integer
     */
    public function getDateCreate()
    {
        return $this->date_create;
    }

    /**
     * Set the value of date_update.
     *
     * @param integer $date_update
     * @return \UsersBundle\Entity\User
     */
    public function setDateUpdate($date_update)
    {
        $this->date_update = $date_update;

        return $this;
    }

    /**
     * Get the value of date_update.
     *
     * @return integer
     */
    public function getDateUpdate()
    {
        return $this->date_update;
    }

    /* -------------------- Manage groups ------------------------- */
    public function getGroups()
    {
        return $this->groups;
    }

    public function setGroups(ArrayCollection $groups)
    {
        $this->groups = $groups;

        return $this;
    }

    /* -------------------- Manage avatar ------------------------- */
    public function getNameFile($avatar) {

        $extension = $avatar->guessExtension() ;
        if($extension == 'jpeg') {
            $extension = 'jpg';
        }

        $name = strtolower($this->username) ;

        $this->img = $name.'.'.$extension ;
        return $name.'.'.$extension ;
    }

    public function getUploadDir() {
        return '/../../../web/avatar' ;
    }

    protected function getUploadRootDir()
    {
        // the absolute directory path where uploaded
        // documents should be saved
        $path = __DIR__. $this->getUploadDir();

        return $path;
    }

    public function guessExtension()
    {
        $type = $this->getMimeType();
        $guesser = ExtensionGuesser::getInstance();

        return $guesser->guess($type);
    }
}