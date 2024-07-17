<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    public function __construct(
        private UserPasswordHasherInterface $hasher
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $user = new User();
        $user->setEmail('admin@test.com')
            ->setRoles(['ROLE_ADMIN'])
            ->setFirstName('Aissatou')
            ->setLastName('BAH')
            ->setTelephone('0701020304')
            ->setBirthDate(new \DateTime('19-05-1988'))
            ->setPassword(
                $this->hasher->hashPassword(
                    new User,
                    'Test1234'
                )
            );

        $manager->persist($user);
        $manager->flush();
    }
}
