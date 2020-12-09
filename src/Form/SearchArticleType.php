<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('mots',SearchType::class,[
                'label'=>false,
                'attr'=>[
                    'class'=>'form-control mr-sm-2',
                    'placeholder'=>'Mots-clés...'
                ],
                'required'=>false
            ])
            ->add('categorie', EntityType::class, [
                'class'=>Category::class,
                'label'=>false,
                'attr'=>[
                    'class'=>'form-control mr-sm-2',
                    'placeholder'=>'Categorie'
                ],
                'required'=>false
            ])
            ->add('Recherche',SubmitType::class,[
                'attr'=>[
                    'class'=>'btn btn-secondary my-2 my-sm-0'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
