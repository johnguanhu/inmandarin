<?php


namespace AppBundle\Form;

use AppBundle\Entity\DataTransformer\ArrayToEntity;
use AppBundle\Entity\Word;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class WordType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('word')
            ->add('description')
            ->add('language')
            ->add('myTranslation', TranslationType::class)
//            ->add('myTranslation', CollectionType::class, array(
//                'entry_type' => TranslationType::class,
//                'allow_add'    => true,
//                'entry_options' => array('label' => false),
//            ))

            ->add('save', SubmitType::class, array('label' => 'Create New Word'))
        ;

//        $builder->get('word')
//            ->addModelTransformer(new CallbackTransformer(
//                function ($tagsAsArray) {
//
//                    dump($tagsAsArray);
//                    // transform the array to a string
//                    return implode(', ', $tagsAsArray);
//                },
//                function ($tagsAsString) {
//
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