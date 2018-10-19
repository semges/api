<?php
// api/src/Controller/UtilisateurSpecial.php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Service\UtilisateurService;

class UtilisateurSpecial
{
    private $utilisateurService;

    public function __construct(UtilisateurService $utilisateurService)
    {
        $this->utilisateurService = $utilisateurService;
    }

    public function __invoke(Utilisateur $data): Utilisateur
    {
        return $this->utilisateurService->addUtilisateur($data->getUsername(), $data->getEmail(), $data->getPassword());
    }
}