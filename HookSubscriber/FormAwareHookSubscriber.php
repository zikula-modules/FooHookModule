<?php

/*
 * This file is part of the Zikula package.
 *
 * Copyright Zikula Foundation - http://zikula.org/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zikula\FooHookModule\HookSubscriber;

use Zikula\Bundle\HookBundle\Category\FormAwareCategory;
use Zikula\Bundle\HookBundle\HookSubscriberInterface;
use Zikula\Common\Translator\TranslatorInterface;

class FormAwareHookSubscriber implements HookSubscriberInterface
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * FormAwareHookSubscriber constructor.
     * @param TranslatorInterface $translator
     */
    public function __construct(TranslatorInterface $translator)
    {
        $this->translator = $translator;
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
        return $this->translator->__('FooHook FormAware Subscribers');
    }

    public function getEvents()
    {
        return [
            FormAwareCategory::TYPE_EDIT => 'zikulafoohookmodule.form_aware_hook.foo.edit',
            FormAwareCategory::TYPE_PROCESS_EDIT => 'zikulafoohookmodule.form_aware_hook.foo.process_edit'
        ];
    }
}
