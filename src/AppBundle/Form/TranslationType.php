<?php

namespace AppBundle\Form;

use AppBundle\Entity\Word;
use Pryon\GoogleTranslatorBundle\Form\Type\LanguageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class TranslationType
 * @package AppBundle\Form
 */
class TranslationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('word', TextType::class, array('attr' => array('class'=>'google_word_2')))
//            ->add('description')
//            ->add('language', ChoiceType::class, array(
//                'attr' => array('class'=>'google_lang_2'),
//                'choices'  => array(
//                    'English' => 'en',
//                    'Chinese' => 'zh',
//                ),
//            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Word::class,
        ));
    }
}
