<?php

namespace App\DataFixtures;

use App\Entity\Author;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class AuthorFixture extends Fixture implements OrderedFixtureInterface
{
    /**
     * @var ReferencesRepository
     */
    private $refRepo;

    /**
     * @var array
     */
    private $authorList;

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
        $this->authorList = $refRepo->getAuthorList();
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager)
    {
        foreach ($this->authorList as $authorName){
            $author = new Author();
            $author->setName($authorName)
                ->setFirstName($this->faker
                ->firstName())
                ->setCountry($this->faker->country);
            $manager->persist($author);
            $this->addReference($authorName,$author);
        }


        $manager->flush();
    }

    public function getOrder()
    {
        return 30;
    }
}
