<?php

namespace App\DataFixtures;

use App\Entity\TrtUser;
use App\Entity\TrtAnnonce;
use App\Entity\TrtContrat;
use App\Entity\TrtEtatAnnonce;
use App\Entity\TrtExperiences;
use App\Entity\TrtProfessions;
use App\Entity\TrtProfilcandidat;
use App\Entity\TrtProfilrecruteur;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class Userfixtures extends Fixture
{
    private $passwordEncoder;
    public function __construct(UserPasswordHasherInterface $passwordEncoder_)
    {
        $this->passwordEncoder = $passwordEncoder_;
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        $user1 = new TrtUser();
        $user1->setEmail('jasminpascal2016@gmail.com');
        $user1->setRoles(['ROLE_ADMIN']);

        $user1->setPassword($this->passwordEncoder->hashPassword($user1, 'AdminJasmin!2022'));
        $manager->persist($user1);
        $user2 = new TrtUser();
        $user2->setEmail('AdminitrateurTrt@laposte.net');
        $user2->setRoles(['ROLE_ADMIN']);

        $user2->setPassword($this->passwordEncoder->hashPassword($user2, 'AdminTrt!2022'));
        $manager->persist($user2);
        $manager->flush();
        // consultant
        $userRecrut = new TrtUser();
        $userRecrut->setEmail("entreprise2022@laposte.net")
            ->setRoles(['ROLE_RECRUTEUR'])
            ->setPassword($this->passwordEncoder->hashPassword($userRecrut, 'recruteurAdmin!2022'));
        $profilRec = new TrtProfilrecruteur();
        $profilRec->setUser($userRecrut);
        $manager->persist($userRecrut);
        $manager->persist($profilRec);
        $manager->flush();
        // Professions
        $listeprofessions = array(
            "Barman/barmaid", "Cuisinier/Cuisinière", "chef de partie",
            "Un/une commis de cuisine", "Pâtissier/Pâtissière", "Sommelier/Sommelière",
            "Serveur/serveuse",
            "plongeur",
            "Gérant/Gérante",
            "Directeur/Directrice de restaurant",
            "Gouvernant/Gouvernante",
            "Femme/Valet de chambre",
            "Maître/Maîtresse d'hôtel",
            "un/une Réceptionniste",
            "Directeur/Directrice d'hotel",
            "directeur/Directrice financier"
        );
        $listecv = array(
            "barman", "cuisinier", "chefdepartie",
            "commisdecuisine", "patissier", "sommelier",
            "serveur", "plongeur", "gerant", "directeur",
            "gouvernant", "valetdechambre",  "maitredhotel", "receptionniste",
            "directeur", "directeurfinancier"
        );

        foreach ($listeprofessions as $profess) {
            $profession = new TrtProfessions();
            $profession->setTitre($profess);
            $arrayProf[] = $profession;
            $manager->persist($profession);
        }
        $manager->flush();
        // liste d 'experiences
        $listeExperiences = array("moins d'un ans d'expérience", "1 an  d'expérience", "2 ans d'expérience", "3 ans d'expériences", "4 ans d'expériences", "5 ans d'expériences", "entre 5 et 10 ans d'expériences", "entre 10 et 15 ans d'expériences", "entre 15 et 20 ans d'expériences", "Plus 20 ans d'expériences");
        foreach ($listeExperiences as $exp) {
            $experience = new TrtExperiences();
            $experience->setTitre($exp);
            $arrayExp[] = $experience;
            $manager->persist($experience);
        }
        $manager->flush();
        // liste Nom
        $listeNoms = array(
            "Martin", "Bernard", "Garnier", "Dubois", "Faure", "Thomas", "Rousseau", "Robert", "Blanc",
            "Richars", "Guerin", "Petit", "Muller", "Durand", "Henry", "Leroy", "Roussel", "Moreau", "Nicolas", "Simon", "Perrin", "Laurent", "Morin", "Lefebvre", "Mathieu", "Michel", "Clement", "Garcia", "Gauthier", "David", "Dumont", "Bertrand", "Lopez", "Roux", "Fontaine", "Vincent", "Chevalier", "Fournier", "Robin"
        );
        $listePrenoms = array(
            "LEO", "GABRIEL ", " RAPHAEL", "ARTHUR", "LOUIS", "JULES", "MAEL", "PATRICK", "LUCAS",
            "HUGO", "NOAH", "JEAN", "GABIN", "SACHA", "REMI", "PAUL", "ETHAN", "NATHAN", "JADE", "LOUISE", "EMMA",
            "ALICE", "AMBRE", "FRANçOISE", "ROSE", "CHLOE", "LEA", "MARTINE", "INES", "ANNA", "MARINE", "JULIA", "ROMY", "LENA", "MARILENE",
            "ELENA", "AGATHE", "EVA"
        );
        // liste de candidats
        for ($i = 1; $i < 15; $i++) {
            $usercand = new TrtUser();
            $nbr = random_int(101, 299);
            $usercand->setRoles(['ROLE_CANDIDAT']);
            $usercand->setValider(0);
            $usercand->setEmail('candidatfaux' . $i . '@laposte.net');
            $usercand->setPassword($this->passwordEncoder->hashPassword($usercand, 'Candidatfaux' . $i . $nbr . '!2022'));
            $manager->persist($usercand);
            $profil = new TrtProfilcandidat();
            $profil->setIdUser($usercand);
            $profil->setNom($listeNoms[random_int(0, count($listeNoms) - 1)]);
            $prenom = strtolower($listePrenoms[random_int(0, count($listePrenoms) - 1)]);
            $profil->setPrenom($prenom);
            $indexpro = random_int(0, count($arrayProf) - 1);
            $profil->setCv($listecv[$indexpro]);
            $profil->setProfession($arrayProf[$indexpro]);
            $profil->setExperience($arrayExp[random_int(0, count($arrayExp) - 1)]);
            $manager->persist($profil);
        }
        $manager->flush();

        $NomRestaurant = array("Le cheval blanc", "La Tour d'Argent", "Auguste ", "Le saint Honoré", "La Table du noble", "Le baudelaire", "Le zola", "Le Jules Verne", "Le palais Royale", "L'argenterie");
        $NomHotel = array("AirHotel", "AcHotel", "ArcHotel", "AtlasHotel", "AstroHotel", "BarceloHotel", "BritHotel", "AtlantisHotel", "CondorHotel", "FranceHotel");
        $Etablisement = array("Restaurant", "Hotel");
        $ville = array("Bordeaux", "Toulouse", "Paris", "Marseille", "Nimes", "Angers", "Nantes", "Lille", "Limoges", "Tours");
        $code = array(330, 310, 750, 130, 300, 490, 440, 590, 870, 370);
        $rue = array(" des puits", "Emile Zola", "François Mitterant", "Jules Vernes", "de la paix", "de la tournelle", "des rosiers", "des petits champs", "de l'église", " Monsieur le prince");
        $typerue = array("rue", "boulevard", "place");
        // liste de recruteurs
        for ($i = 1; $i < 15; $i++) {
            $userRec = new TrtUser();
            $nbr = random_int(101, 299);
            $userRec->setValider(0);
            $userRec->setRoles(['ROLE_RECRUTEUR']);
            $userRec->setEmail('recruteurfaux' . $i . '@laposte.net');
            $userRec->setPassword($this->passwordEncoder->hashPassword($userRec, 'recruteurfaux' . $i . $nbr . '!2022'));
            $manager->persist($userRec);
            $profilrec = new TrtProfilrecruteur();
            $etab = random_int(0, 1);
            $profilrec->setEtablissement($Etablisement[$etab]);
            $profilrec->setUser($userRec);
            if ($etab == 0)
                $profilrec->setNom($NomRestaurant[random_int(0, count($NomRestaurant) - 1)]);
            else
                $profilrec->setNom($NomHotel[random_int(0, count($NomHotel) - 1)]);
            $numero = random_int(10, 99);
            $adress = $numero . ' ' . $typerue[random_int(0, 2)] . ' ' . $rue[random_int(0, 9)];
            $profilrec->setAdresse($adress);
            $indexville = random_int(0, 9);
            $profilrec->setVille($ville[$indexville]);
            $profilrec->setCodePostal($code[$indexville] * 100 + random_int(10, 100));
            $arrayRecruteur[] = $profilrec;
            $manager->persist($profilrec);
        }
        $manager->flush();
        // annonce

        $arrayEt = array("Annulé", "Pourvue", "Non pourvue");
        $arrayCont = array("CDI", "CDD saisonnier", "CDD 2 mois", "CDD 3 mois", "CDD 6 mois", "CDD 1 ans");
        foreach ($arrayEt as $et) {
            $etat = new TrtEtatAnnonce();
            $etat->setTitre($et);
            $arrayEtat[] = $etat;
            $manager->persist($etat);
        }
        foreach ($arrayCont as $ct) {
            $ctr = new TrtContrat();
            $ctr->setTitre($ct);
            $arrayCtr[] = $ctr;
            $manager->persist($ctr);
        }
        $manager->flush();
        for ($i = 1; $i < 10; $i++) {
            $annonce = new TrtAnnonce();
            $indexpro = random_int(0, count($arrayProf) - 1);

            $annonce->setExperience($arrayExp[random_int(0, count($arrayExp) - 1)]);
            $annonce->setContrat($arrayCtr[random_int(0, count($arrayCtr) - 1)]);
            $annonce->setEtat($arrayEtat[2]);
            $indexrecruteur = random_int(0, count($arrayRecruteur) - 1);
            $recruteur = $arrayRecruteur[$indexrecruteur];
            $annonce->getRecruteur($recruteur);

            if ($recruteur->getEtablissement() == 'Restaurant')
                $indexpro = random_int(0, 9);
            else $indexpro = random_int(10, 15);
            $annonce->setProfession($arrayProf[$indexpro]);
            $annonce->setExperience($arrayExp[random_int(0, count($arrayExp) - 1)]);
            $annonce->setDescription("Homines enim eruditos et sobrios ut infaustos et inutiles vitant, eo quoque accedente quod et nomenclatores adsueti haec et talia venditare, mercede accepta lucris quosdam et prandiis inserunt subditicios ignobiles et obscuros.");
            $salaire = array(22000, 23000, 25000, 28000, 24000, 30000);

            $annonce->setSalaireAnnuel($salaire[random_int(0, 5)]);
            $annonce->setHoraire('8h / jour');
            $annonce->setValider(0);
            $manager->persist($annonce);
        }
        $manager->flush();
    }
}
