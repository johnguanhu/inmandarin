<?php

namespace AppBundle\Form;

use AppBundle\Entity\Word;
use Pryon\GoogleTranslatorBundle\Form\Type\LanguageType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
            ->add('word')
//            ->add('description')
            ->add('language', ChoiceType::class, array(
                'choices'  => array(
                    'English' => 'en',
                    'Chinese' => 'zh',
                ),
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Word::class,
        ));
    }
}
