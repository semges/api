<?php

namespace App\Service;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Repository\UtilisateurRepository;
use App\Entity\Utilisateur;

class UtilisateurService
{
    /**
     * @var UtilisateurRepositoryInterface 
     */
    private $_utilisateurRepository;
    private $_encoder;
   
    public function __construct( UtilisateurRepository $utilisateurRepository, UserPasswordEncoderInterface $encoded)
    {
        $this->_utilisateurRepository = $utilisateurRepository;
        $this->_encoder = $encoded;
    }

    /**
     * Premet d'ajouter un Utilisateur avec un mot de passe crypé dans la BD
     */
    public function addUtilisateur(string $username, string $email, string $password): Utilisateur
    {        
        $utilisateur = new Utilisateur();        
        $password = $this->_encoder->encodePassword($utilisateur, $password);
        $utilisateur->setUsername($username);
        $utilisateur->setPassword($password);
        $utilisateur->setEmail($email);
        $this->_utilisateurRepository->save($utilisateur);
        return $utilisateur;
    }
}
