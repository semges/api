<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ApiResource(
 *     collectionOperations={
 *     "post",
 *     "special"={
 *         "method"="POST",
 *         "path"="/utilisateurs/special.{_format}",
 *          "requirements"={
 *              "_format": "\s+"
 *           },
 *         "controller"=App\Controller\UtilisateurSpecial::class
 *     }
 * })
 * @ORM\Entity(repositoryClass="App\Repository\UtilisateurRepository")
 * @UniqueEntity(fields="email", message="Cet email est déjà enregistré en base.")
 * @UniqueEntity(fields="username", message="Cet identifiant est déjà enregistré en base")
 * 
 */
class Utilisateur implements UserInterface, \Serializable
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
 
    /**
     * @ORM\Column(type="string", length=25, unique=true)
     * @Assert\NotBlank()
     * @Assert\Length(max=25)
     */
    private $username;
 
    /**
     * @ORM\Column(type="string")
     */
    private $password;
 
    /**
     * @ORM\Column(type="string", length=60, unique=true)
     * @Assert\NotBlank()
     * @Assert\Length(max=60)
     * @Assert\Email()
     */
    private $email;
 
    /**
     * @ORM\Column(name="is_active", type="boolean")
     */
    private $isActive;
    
     /**
     * @var array
     * @ORM\Column(type="array")
     */
    private $roles;

    public function __construct()
    {
        $this->isActive = true;
        $this->roles = ['ROLE_USER'];
    }
     
    /*
     * Get id
     */
    public function getId()
    {
        return $this->id;
    }
 
    public function getUsername()
    {
        return $this->username;
    }
 
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }
 
 
    public function getPassword()
    {
        return $this->password;
    }
 
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }
 
    /*
     * Get email
     */
    public function getEmail()
    {
        return $this->email;
    }
 
    /*
     * Set email
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }
 
    /*
     * Get isActive
     */
    public function getIsActive()
    {
        return $this->isActive;
    }
 
    /*
     * Set isActive
     */
    public function setIsActive($isActive)
    {
        $this->isActive = $isActive;
        return $this;
    }

     // modifier la méthode getRoles
     public function getRoles()
     {
         return $this->roles; 
     }

     public function setRoles(array $roles)
     {
         if (!in_array('ROLE_USER', $roles))
         {
             $roles[] = 'ROLE_USER';
         }
         foreach ($roles as $role)
         {
             if(substr($role, 0, 5) !== 'ROLE_') {
                 throw new InvalidArgumentException("Chaque rôle doit commencer par 'ROLE_'");
             }
         }
         $this->roles = $roles;
         return $this;
     }
 
    public function getSalt()
    {
        // pas besoin de salt puisque nous allons utiliser bcrypt
        // attention si vous utilisez une méthode d'encodage différente !
        // il faudra décommenter les lignes concernant le salt, créer la propriété correspondante, et renvoyer sa valeur dans cette méthode
        return null;
    }
 
    public function eraseCredentials()
    {
    }
 
    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->username,
            $this->password,
            $this->isActive,
            // voir remarques sur salt plus haut
            // $this->salt,
        ));
    }
 
    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list (
            $this->id,
            $this->username,
            $this->password,
            $this->isActive,
            // voir remarques sur salt plus haut
            // $this->salt
        ) = unserialize($serialized);
    }
        

}
