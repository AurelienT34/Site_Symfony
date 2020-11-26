<?php

namespace App\Form;

use App\Entity\UserName;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class EditProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email',EmailType::class, [
                'constraints'=>[
                    new NotBlank([
                        'message'=>'Merci de saisir une adresse email'
                    ])
                ],
                'required'=>true,
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('username')
            ->add('Valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserName::class,
        ]);
    }
}
