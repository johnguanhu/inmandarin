<?php

namespace AppBundle\Form;

use AppBundle\Entity\Word;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TranslationEmbebedForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('word', EntityType::class, [
                'class' => Word::class,
                'choice_label' => 'trans',
//                'query_builder' => function(UserRepository $repo) {
//                    return $repo->createIsScientistQueryBuilder();
//                }
            ])
            ->add('description')
    ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Word::class
        ]);

    }
}
