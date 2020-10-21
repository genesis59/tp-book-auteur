<?php

namespace App\DataFixtures;

use App\Entity\Editeur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class PublisherFixture extends Fixture implements OrderedFixtureInterface
{
    /**
     * @var ReferencesRepository
     */
    private $refRepo;

    /**
     * @var array
     */
    private $publisherList;

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
        $this->publisherList = $refRepo->getPublisherList();
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager)
    {
        foreach ($this->publisherList as $publisherName){
            $publisher = new Editeur();
            $publisher->setName($publisherName);
            $this->addReference($publisherName,$publisher);
            $manager->persist($publisher);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 1;
    }
}
