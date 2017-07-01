<?php

/*
 * This file is part of the ZikulaPagesModule package.
 *
 * Copyright Zikula Foundation - http://zikula.org/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zikula\FooHookModule\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\EqualTo;
use Zikula\Common\Translator\IdentityTranslator;

class FooType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $translator = $options['translator'];
        $builder
            ->add('textField', TextType::class, [
                'constraints' => [new EqualTo('six')],
                'help' => $translator->__('enter `six`')
            ])
            ->add('check', CheckboxType::class, [
                'required' => false,
                'label' =>  $translator->__('foo check label')
            ])
            ->add('foochoice', ChoiceType::class, [
                'choices' => [
                    'A' => 'A-1',
                    'B' => 'B-1',
                    'C' => 'C-1',
                ],
                'required' => false,
                'placeholder' =>  $translator->__('All')
            ])
        ;
    }

    public function getBlockPrefix()
    {
        return 'zikulafoomodule_fooform';
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'translator' => new IdentityTranslator(),
        ]);
    }
}
