<?php

/*
 * This file is part of the Zikula package.
 *
 * Copyright Zikula Foundation - http://zikula.org/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zikula\FooHookModule\HookProvider;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Validator\Constraints\EqualTo;
use Zikula\Bundle\HookBundle\Category\FormAwareCategory;
use Zikula\Bundle\HookBundle\FormAwareHook\FormAwareHook;
use Zikula\Bundle\HookBundle\FormAwareHook\FormAwareResponse;
use Zikula\Bundle\HookBundle\HookProviderInterface;
use Zikula\Bundle\HookBundle\ServiceIdTrait;
use Zikula\Common\Translator\TranslatorInterface;
use Zikula\FooHookModule\Form\Type\FooType;

class FormAwareHookProvider implements HookProviderInterface
{
    use ServiceIdTrait;

    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var FormFactoryInterface
     */
    private $formFactory;

    /**
     * ProviderHandler constructor.
     * @param SessionInterface $session
     * @param TranslatorInterface $translator
     * @param FormFactoryInterface $formFactory
     */
    public function __construct(
        SessionInterface $session,
        TranslatorInterface $translator,
        FormFactoryInterface $formFactory
    ) {
        $this->session = $session;
        $this->translator = $translator;
        $this->formFactory = $formFactory;
    }

    public function getOwner()
    {
        return 'ZikulaFooHookModule';
    }

    public function getCategory()
    {
        return FormAwareCategory::NAME;
    }

    public function getTitle()
    {
        return $this->translator->__('FooHook Provider');
    }

    public function getProviderTypes()
    {
        return [
            FormAwareCategory::TYPE_EDIT => 'edit',
            FormAwareCategory::TYPE_PROCESS_EDIT => 'processEdit',
        ];
    }

    public function edit(FormAwareHook $hook)
    {
        /**
         * Simple method
         */
        $hook
            ->formAdd('test', TextType::class, [
                'label' => 'FormAwareHookProvider test',
                'constraints' => [new EqualTo('blue')],
                'help' => 'You must type `blue` in this box',
            ])
            ->addTemplate('@ZikulaFooHookModule/Hook/test.html.twig', ['bar' => 'This is a template var!']);

        /**
         * Better method
         */
        $myForm = $this->formFactory->create(FooType::class, null, [
            'auto_initialize' => false, // required
            'mapped' => false // required
        ]);
        $hook
            ->formAdd($myForm)
            ->addTemplate(('@ZikulaFooHookModule/Hook/test_fooform.html.twig'))
        ;
    }

    public function processEdit(FormAwareResponse $hook)
    {
        // simple
        $test = $hook->getFormData('test');
        $this->session->getFlashBag()->add('success', sprintf('The FormAwareHookProvider form was processed and the answer was %s', $test));
        // better
        $fooForm = $hook->getFormData('zikulafoomodule_fooform');
        $this->session->getFlashBag()->add('success', sprintf('The FormAwareHookProvider foo form was processed and the answer was %s', $fooForm['textField']));
    }
}
