<?php

namespace AppBundle\Form;

use AppBundle\Entity\Word;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TranslationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('word')
//            ->add('description')
//            ->add('language')
        ;

//        $builder->get('myTranslation')
//            ->addModelTransformer(new CallbackTransformer(
//                function ($tagsAsArray) {
//                    dump($tagsAsArray);
//                    // transform the array to a string
//                    return implode(', ', $tagsAsArray);
//                },
//                function ($tagsAsString) {
//                    // transform the string back to an array
//                    return explode(', ', $tagsAsString);
//                }
//            ))
//        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Word::class,
        ));
    }
}
