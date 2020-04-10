<?php

namespace App\DataFixtures;

use Faker;
use App\Entity\Article;
use App\DataFixtures\UserFixtures;
use App\Repository\UserRepository;
use App\DataFixtures\CategoryFixtures;
use App\Repository\CategoryRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    const AMOUNT = 15;

    private $categoryRepository;

    public function __construct(
        CategoryRepository $categoryRepository,
        UserRepository $userRepository
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->userRepository = $userRepository;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        $categories = $this->categoryRepository->findAll();
        $users = $this->userRepository->findAll();

        for ($i = 0; $i < self::AMOUNT; $i += 1) {
            $article = new Article();

            $createdAt = $faker->dateTime();
            $updatedAt = $faker->dateTimeBetween($createdAt, 'now');

            $article
                ->setTitle($faker->catchphrase())
                ->setCover('https://i.picsum.photos/id/' . rand(0, 1000) . '/1280/768.jpg')
                ->setContent($faker->realText(500))
                ->setCreatedAt($createdAt)
                ->setUpdatedAt($updatedAt)
                ->setCategory($categories[rand(0, sizeof($categories) - 1)])
                ->setAuthor($users[rand(0, sizeof($users) - 1)])
            ;
            
            $manager->persist($article);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            CategoryFixtures::class,
            UserFixtures::class
        );
    }
}
