<?php

namespace App\DataFixtures;

use App\Entity\Auteur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class AuteurFixture extends Fixture implements OrderedFixtureInterface
{
    /**
     * @var ReferencesRepository
     */
    private $refRepo;

    /**
     * @var array
     */
    private $auteurList;

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
        $this->auteurList = $refRepo->getAuteurList();
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager)
    {
        foreach ($this->auteurList as $authorName){
            $author = new Auteur();
            $author->setName($authorName)
                ->setPrenom($this->faker
                ->firstName())
            ;
            $this->addReference($authorName,$author);

            $manager->persist($author);
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }

    public function getOrder()
    {
        return 40;
    }
}
