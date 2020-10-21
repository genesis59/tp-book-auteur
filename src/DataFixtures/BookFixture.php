<?php

namespace App\DataFixtures;

use App\Entity\Book;
use App\Entity\Editeur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class BookFixture extends Fixture implements OrderedFixtureInterface
{
    /**
     * @var ReferencesRepository
     */
    private $refRepo;

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
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager)
    {
        $numberOfBooks = 100;
        for ($i=0; $i<= $numberOfBooks; $i++){
            $publisher = new Book();
            $publisher
                ->setTitle($this->faker->catchPhrase())
                ->setPrice($this->faker->numberBetween(500,100000)/100)
                ->addAuteur($this->getReference($this->refRepo->getRandomAuteur()))
                ->setEditeur($this->getReference($this->refRepo->getRandomPublisher()))
                ->setGenre($this->getReference($this->refRepo->getRandomGenre()))
                ->setPublishedAt($this->faker->dateTimeBetween('-20 years'))
            ;
            // gestion des tags
            $numberOfTags = mt_rand(0,4);
            for($k=1;$k<=$numberOfTags;$k++){
                $tag = $this->getReference($this->refRepo->getRandomTag());
                $publisher->addTag($tag);
            }


            $manager->persist($publisher);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 100;
    }
}
