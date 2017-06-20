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
use Zikula\FooHookModule\Handler\ProviderHandler;

class HookContainer extends AbstractHookContainer
{
    const SUBSCRIBER_UIAREANAME = 'zikula.foohookmodule.subscriber';
    const SUBSCRIBER_FILTER_UIAREANAME = 'zikula.foohookmodule.filter.subscriber';
    const PROVIDER_UIAREANAME = 'zikula.foohookmodule.provider';
    const PROVIDER_FILTER_UIAREANAME = 'zikula.foohookmodule.filter.provider';

    /**
     * Define the hook bundles supported by this module.
     *
     * @return void
     */
    protected function setupHookBundles()
    {
        $bundle = new SubscriberBundle('ZikulaFooHookModule', self::SUBSCRIBER_UIAREANAME, 'ui_hooks', $this->__('FooHook Subscribers'));
        $bundle->addEvent('display_view', 'foo.ui_hooks.display_view');
        $bundle->addEvent('form_edit', 'foo.ui_hooks.form_edit');
        $bundle->addEvent('validate_edit', 'foo.ui_hooks.validate_edit');
        $bundle->addEvent('process_edit', 'foo.ui_hooks.process_edit');
        $this->registerHookSubscriberBundle($bundle);

        $bundle = new SubscriberBundle('ZikulaFooHookModule', self::SUBSCRIBER_FILTER_UIAREANAME, 'filter_hooks', $this->__('Foo Subscriber Filter Hooks'));
        $bundle->addEvent('filter', 'foo.filter_hooks.filter');
        $this->registerHookSubscriberBundle($bundle);

        $bundle = new ProviderBundle('ZikulaFooHookModule', self::PROVIDER_UIAREANAME, 'ui_hooks', $this->__('FooHook Provider'));
        $bundle->addServiceHandler('display_view', ProviderHandler::class, 'uiView', 'zikula_foohook_module.hook_handler');
        $bundle->addServiceHandler('form_edit', ProviderHandler::class, 'uiEdit', 'zikula_foohook_module.hook_handler');
        $bundle->addServiceHandler('validate_edit', ProviderHandler::class, 'validateEdit', 'zikula_foohook_module.hook_handler');
        $bundle->addServiceHandler('process_edit', ProviderHandler::class, 'processEdit', 'zikula_foohook_module.hook_handler');
        $this->registerHookProviderBundle($bundle);

        $bundle = new ProviderBundle('ZikulaFooHookModule', self::PROVIDER_FILTER_UIAREANAME, 'filter_hooks', $this->__('FooHook Filter Provider'));
        $bundle->addServiceHandler('filter', ProviderHandler::class, 'filter', 'zikula_foohook_module.hook_handler.filter');
        $this->registerHookProviderBundle($bundle);
    }
}
