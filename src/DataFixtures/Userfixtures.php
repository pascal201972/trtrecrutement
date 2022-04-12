<?php

namespace App\DataFixtures;

use App\Entity\TrtUser;
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
        $manager->persist($user1);


        $manager->flush();
    }
}
