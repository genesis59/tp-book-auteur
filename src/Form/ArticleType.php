<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Author;
use App\Form\DataTransformer\TagDataTransformer;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    /**
     * @var TagDataTransformer
     */
    private $tagTransformer;

    /**
     * ArticleType constructor.
     * @param TagDataTransformer $tagTransformer
     */
    public function __construct(TagDataTransformer $tagTransformer)
    {
        $this->tagTransformer = $tagTransformer;
    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title',TextType::class,['label'=>'Titre'])
            /*
            ->add('createdAt',DateType::class,[
                'widget' => 'single_text'
            ])*/
            ->add('author',EntityType::class,[
                'class'=> Author::class,
                'choice_label' => 'name'
            ])
            ->add('tags',TextType::class,['label' => 'Les tags'])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider'
            ])
        ;

            $builder->get('tags')->addModelTransformer($this->tagTransformer);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
