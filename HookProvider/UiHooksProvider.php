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

use Zikula\Bundle\HookBundle\Category\UiHooksCategory;
use Zikula\Bundle\HookBundle\Hook\DisplayHook;
use Zikula\Bundle\HookBundle\Hook\DisplayHookResponse;
use Zikula\Bundle\HookBundle\HookProviderInterface;
use Zikula\Bundle\HookBundle\ServiceIdTrait;
use Zikula\Common\Translator\TranslatorInterface;

class UiHooksProvider implements HookProviderInterface
{
    use ServiceIdTrait;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * ProviderHandler constructor.
     * @param TranslatorInterface $translator
     */
    public function __construct(
        TranslatorInterface $translator
    ) {
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
        return $this->translator->__('FooHook Display Provider');
    }

    public function getProviderTypes()
    {
        return [
            UiHooksCategory::TYPE_DISPLAY_VIEW => ['display', 'display_more'],
        ];
    }

    public function display(DisplayHook $hook)
    {
        $hook->setResponse(new DisplayHookResponse('provider.zikulafoohookmodule.form_aware_hook.foo', 'This is the FormAwareHookProvider display hook response'));
    }

    public function display_more(DisplayHook $hook)
    {
        $hook->setResponse(new DisplayHookResponse('provider.zikulafoohookmodule.form_aware_hook.foo', 'This is a SECOND FormAwareHookProvider display_more hook response'));
    }
}
