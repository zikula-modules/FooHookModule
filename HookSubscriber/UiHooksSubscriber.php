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

use Zikula\Bundle\HookBundle\Category\UiHooksCategory;
use Zikula\Bundle\HookBundle\HookSubscriberInterface;
use Zikula\Common\Translator\TranslatorInterface;

class UiHooksSubscriber implements HookSubscriberInterface
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
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
        return UiHooksCategory::NAME;
    }

    public function getTitle()
    {
        return $this->translator->__('FooHook Subscribers');
    }

    public function getEvents()
    {
        return [
            UiHooksCategory::TYPE_DISPLAY_VIEW => 'zikulafoohookmodule.ui_hooks.foo.display_view',
            UiHooksCategory::TYPE_FORM_EDIT => 'zikulafoohookmodule.ui_hooks.foo.form_edit',
            UiHooksCategory::TYPE_VALIDATE_EDIT => 'zikulafoohookmodule.ui_hooks.foo.validate_edit',
            UiHooksCategory::TYPE_PROCESS_EDIT => 'zikulafoohookmodule.ui_hooks.foo.process_edit'
        ];
    }
}
