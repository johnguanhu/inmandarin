<?php

namespace AppBundle\Form;

use AppBundle\Entity\Word;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
            ->add('word', TextType::class, array('attr' => array('class'=>'google_word')))
//            ->add('description')
            ->add('language', ChoiceType::class, array(
                'attr' => array('class'=>'google_lang'),
                'choices'  => array(
                    'English' => 'en',
                    'Chinese' => 'zh',
                ),
            ))
            ->add('myTranslation', CollectionType::class, array(
                'entry_type' => TranslationType::class,
                'allow_add'    => true,
                'allow_delete' => true,
                'entry_options' => array('label' => false),
            ))
            ->add('otherTranslation', CollectionType::class, array(
                'entry_type' => TranslationType::class,
                'allow_add'    => true,
                'allow_delete' => true,
                'entry_options' => array('label' => false),
            ))
            ->add('save', SubmitType::class, array('label' => 'Save Word'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Word::class,
        ));
    }
}