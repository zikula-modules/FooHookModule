<?php

/*
 * This file is part of the ZikulaFooModule package.
 *
 * Copyright Zikula Foundation - http://zikula.org/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zikula\FooHookModule\Container;

use Zikula\Bundle\HookBundle\AbstractHookContainer;
use Zikula\Bundle\HookBundle\Bundle\ProviderBundle;
use Zikula\Bundle\HookBundle\Bundle\SubscriberBundle;
use Zikula\Bundle\HookBundle\Category\FilterHooksCategory;
use Zikula\Bundle\HookBundle\Category\UiHooksCategory;
use Zikula\FooHookModule\Handler\ProviderHandler;

class HookContainer extends AbstractHookContainer
{
    const SUBSCRIBER_UIAREANAME = 'subscriber.zikulafoohookmodule.ui_hooks.foo'; // <type>.<name>.<category>.<areaname>
    const SUBSCRIBER_FILTER_UIAREANAME = 'subscriber.zikulafoohookmodule.filter_hooks.foo';
    const PROVIDER_UIAREANAME = 'provider.zikulafoohookmodule.ui_hooks.foo';
    const PROVIDER_FILTER_UIAREANAME = 'provider.zikulafoohookmodule.filter_hooks.foo';

    /**
     * Define the hook bundles supported by this module.
     *
     * @return void
     */
    protected function setupHookBundles()
    {
        /**
         * Subscriber
         */
        $bundle = new SubscriberBundle('ZikulaFooHookModule', self::SUBSCRIBER_UIAREANAME, UiHooksCategory::NAME, $this->__('FooHook Subscribers'));
        $bundle->addEvent(UiHooksCategory::TYPE_DISPLAY_VIEW, 'zikulafoohookmodule.ui_hooks.foo.display_view'); // <module>.<category>.<area>.<type>
        $bundle->addEvent(UiHooksCategory::TYPE_FORM_EDIT, 'zikulafoohookmodule.ui_hooks.foo.form_edit');
        $bundle->addEvent(UiHooksCategory::TYPE_VALIDATE_EDIT, 'zikulafoohookmodule.ui_hooks.foo.validate_edit');
        $bundle->addEvent(UiHooksCategory::TYPES_PROCESS_EDIT, 'zikulafoohookmodule.ui_hooks.foo.process_edit');
        $this->registerHookSubscriberBundle($bundle);

        $bundle = new SubscriberBundle('ZikulaFooHookModule', self::SUBSCRIBER_FILTER_UIAREANAME, FilterHooksCategory::NAME, $this->__('Foo Subscriber Filter Hooks'));
        $bundle->addEvent(FilterHooksCategory::TYPE_FILTER, 'zikulafoohookmodule.filter_hooks.foo.filter');
        $this->registerHookSubscriberBundle($bundle);

        /**
         * Provider
         */
        $bundle = new ProviderBundle('ZikulaFooHookModule', self::PROVIDER_UIAREANAME, UiHooksCategory::NAME, $this->__('FooHook Provider'));
        $bundle->addServiceHandler(UiHooksCategory::TYPE_DISPLAY_VIEW, ProviderHandler::class, 'uiView', 'zikula_foohook_module.hook_handler');
        $bundle->addServiceHandler(UiHooksCategory::TYPE_FORM_EDIT, ProviderHandler::class, 'uiEdit', 'zikula_foohook_module.hook_handler');
        $bundle->addServiceHandler(UiHooksCategory::TYPE_VALIDATE_EDIT, ProviderHandler::class, 'validateEdit', 'zikula_foohook_module.hook_handler');
        $bundle->addServiceHandler(UiHooksCategory::TYPES_PROCESS_EDIT, ProviderHandler::class, 'processEdit', 'zikula_foohook_module.hook_handler');
        $this->registerHookProviderBundle($bundle);

        $bundle = new ProviderBundle('ZikulaFooHookModule', self::PROVIDER_FILTER_UIAREANAME, FilterHooksCategory::NAME, $this->__('FooHook Filter Provider'));
        $bundle->addServiceHandler(FilterHooksCategory::TYPE_FILTER, ProviderHandler::class, 'filter', 'zikula_foohook_module.hook_handler.filter');
        $this->registerHookProviderBundle($bundle);
    }
}
