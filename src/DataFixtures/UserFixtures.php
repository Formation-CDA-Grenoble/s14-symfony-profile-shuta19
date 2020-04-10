<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    const AMOUNT = 5;

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        $user = new User();

        $user
            ->setEmail('admin@test.com')
            ->setName('admin')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'admin'
            ))
        ;

        $manager->persist($user);

        for ($i = 0; $i < self::AMOUNT; $i += 1) {
            $user = new User();

            $user
                ->setEmail($faker->email())
                ->setName($faker->userName())
                ->setPassword($this->passwordEncoder->encodePassword(
                    $user,
                    'motdepasse'
                ))
            ;

            $manager->persist($user);
        }
        
        $manager->flush();
    }
}
