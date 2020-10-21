<?php

namespace App\DataFixtures;

use App\Entity\Genre;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class GenreFixture extends Fixture implements OrderedFixtureInterface
{
    /**
     * @var ReferencesRepository
     */
    private $refRepo;

    /**
     * @var array
     */
    private $genreList;

    /**
     * @var Generator
     */
    private $faker;

    /**
     * AuthorFixture constructor.
     * @param ReferencesRepository $refRepo
     */
    public function __construct(ReferencesRepository $refRepo)
    {
        $this->refRepo = $refRepo;
        $this->genreList = $refRepo->getGenreList();
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager)
    {
        foreach ($this->genreList as $genreName){
            $genre = new Genre();
            $genre->setName($genreName);
            $this->addReference($genreName,$genre);
            $manager->persist($genre);

        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 10;
    }
}
