<?php


namespace App\Form\DataTransformer;


use App\Entity\Tags;
use App\Repository\TagsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\DataTransformerInterface;

class TagDataTransformer implements DataTransformerInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $manager;
    /**
     * @var TagsRepository
     */
    private $repository;

    /**
     * TagDataTransformer constructor.
     * @param EntityManagerInterface $manager
     * @param TagsRepository $repository
     */
    public function __construct(EntityManagerInterface $manager, TagsRepository $repository)
    {
        $this->manager = $manager;
        $this->repository = $repository;
    }


    /**
     * @param ArrayCollection $value
     * @return String
     */
    public function transform($value)
    {
        $tagsArray = $value->toArray();
        $tagList = "";
        foreach ($tagsArray as $tag){
            $tagList .=$tag->getTagName(). ",";
        }
        return $tagList;
    }

    public function reverseTransform($value)
    {
        $tagsCollection = new ArrayCollection();
        $tagsArray = explode(',',  $value);

        foreach ($tagsArray as $item) {
            $item = trim($item);
            if(! empty($item)){

                $tag = $this->repository->findOneByTagName($item);

                if(! $tag){
                    $tag = new Tags();
                    $tag->setTagName(trim($item));
                    $this->manager->persist($tag);
                    $this->manager->flush();
                }

                $tagsCollection->add($tag);
            }

        }
        return $tagsCollection;
    }
}