<?php

namespace App\DataFixtures;

use App\Entity\Tags;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Faker\Generator;

class TagsFixture extends Fixture implements OrderedFixtureInterface
{
    /**
     * @var ReferencesRepository
     */
    private $refRepo;

    /**
     * @var array
     */
    private $tagsList;

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
        $this->tagsList = $refRepo->getTagList();
        $this->faker = Factory::create();
    }

    public function load(ObjectManager $manager)
    {
        foreach ($this->tagsList as $tagsName){
            $tag = new Tags();
            $tag->setTagName($tagsName);
            $this->addReference("tag_$tagsName", $tag);
            $manager->persist($tag);
        }

        $manager->flush();
    }

    public function getOrder()
    {
        return 20;
    }
}
