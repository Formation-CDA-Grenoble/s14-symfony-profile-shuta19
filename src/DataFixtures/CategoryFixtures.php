<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker;

class CategoryFixtures extends Fixture
{
    const AMOUNT = 5;

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($i = 0; $i < self::AMOUNT; $i += 1) {
            $category = new Category();

            $category
                ->setName($faker->jobTitle())
                ->setDescription($faker->realText(250))
                ->setImage('https://i.picsum.photos/id/' . rand(0, 1000) . '/1280/768.jpg')
            ;

            $manager->persist($category);
        }

        $manager->flush();
    }
}
