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

use Zikula\Bundle\HookBundle\Category\FilterHooksCategory;
use Zikula\Bundle\HookBundle\Hook\FilterHook;
use Zikula\Bundle\HookBundle\HookProviderInterface;
use Zikula\Bundle\HookBundle\ServiceIdTrait;
use Zikula\Common\Translator\TranslatorInterface;

class FilterHooksProvider implements HookProviderInterface
{
    use ServiceIdTrait;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
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
        return FilterHooksCategory::NAME;
    }

    public function getTitle()
    {
        return $this->translator->__('FooHook FilterHooks Provider');
    }

    public function getProviderTypes()
    {
        return [
            FilterHooksCategory::TYPE_FILTER => ['filter1', 'filter2', 'filter3']
        ];
    }

    public function filter1(FilterHook $hook)
    {
        $hook->setData($hook->getData() . '::1');
    }

    public function filter2(FilterHook $hook)
    {
        $hook->setData($hook->getData() . '::2');
    }

    public function filter3(FilterHook $hook)
    {
        $hook->setData($hook->getData() . '::3');
    }
}
