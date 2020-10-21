<?php

namespace App\Form;

use App\Entity\Auteur;
use App\Entity\Book;
use App\Entity\Editeur;
use App\Entity\Genre;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BookType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /*$builder
            ->add('title',TextType::class,[
                'attr' => ['placeholder'=>'Entrer votre recherche ici'],
                'label'=> ' '
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Valider'
            ])
        ;*/
        $builder
            ->add('title',TextType::class)
            ->add('publishedAt')
            ->add('price')
            ->add('genre', EntityType::class,[
                'class' => Genre::class,
                'choice_label'=> 'name'
            ])
            ->add('editeur', EntityType::class,[
                'class' => Editeur::class,
                'choice_label'=> 'name'
            ])
            ->add('auteur', CollectionType::class,[
                'entry_type' => AuteurType::class,
                'entry_options'=>['label'=>false],
                'allow_add'=> true,
                'allow_delete' =>true,
                'label'=> false,
                'attr'=>['class' => 'col-12']
            ])
            ->add('submit', SubmitType::class)
        ;



    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Book::class,
        ]);
    }
}
