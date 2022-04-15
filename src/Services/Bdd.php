<?php

namespace App\Services;

use App\Repository\TrtUserRepository;
use App\Repository\TrtProfilcandidatRepository;
use App\Repository\TrtProfilrecruteurRepository;

class Bdd
{
    private $reposUser;
    private $reposProfilCdt;
    private $reposProfilRecr;
    public function __construct(TrtUserRepository $reposUser_, TrtProfilcandidatRepository $reposProfilCdt_, TrtProfilrecruteurRepository $reposProfilRecr_)
    {
        $this->reposUser = $reposUser_;
        $this->reposProfilCdt = $reposProfilCdt_;
        $this->reposProfilRecr = $reposProfilRecr_;
    }
    public function getUserRole($role)
    {
        $userRoles = array();
        $listeuser = $this->reposUser->findAll();
        foreach ($listeuser as $user) {
            $roles = $user->getRoles();
            if ($roles[0] == $role) {
                $userRoles[] = $user;
            }
        }
        return $userRoles;
    }

    public function getProfilUserRole($role)
    {
        $userprofil = array();
        $listeuser = $this->reposUser->findAll();
        foreach ($listeuser as $user) {
            $roles = $user->getRoles();
            if ($roles[0] == $role) {
                if ($role == "ROLE_CANDIDAT")
                    $profil = $this->reposProfilCdt->findProfilByUser($user);
                if ($role == "ROLE_RECRUTEUR")
                    $profil = $this->reposProfilRecr->findProfilByUser($user);
                $userprofil[] = $profil;
            }
        }
        return $userprofil;
    }

    public function isprofilComplet(){
        
    }
}
