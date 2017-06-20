<?php

/*
 * This file is part of the Zikula package.
 *
 * Copyright Zikula Foundation - http://zikula.org/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Zikula\FooHookModule\Handler;

use Symfony\Component\HttpFoundation\RequestStack;
use Zikula\Bundle\HookBundle\Hook\DisplayHook;
use Zikula\Bundle\HookBundle\Hook\DisplayHookResponse;
use Zikula\Bundle\HookBundle\Hook\FilterHook;
use Zikula\Bundle\HookBundle\Hook\ProcessHook;
use Zikula\Bundle\HookBundle\Hook\ValidationHook;
use Zikula\Bundle\HookBundle\Hook\ValidationResponse;
use Zikula\FooHookModule\Container\HookContainer;

class ProviderHandler
{
    /**
     * @var \Twig_Environment
     */
    private $twig;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * ProviderHandler constructor.
     * @param \Twig_Environment $twig
     */
    public function __construct(\Twig_Environment $twig, RequestStack $requestStack)
    {
        $this->twig = $twig;
        $this->requestStack = $requestStack;
    }

    public function uiView(DisplayHook $hook)
    {
        $hook->setResponse(new DisplayHookResponse(HookContainer::PROVIDER_UIAREANAME, 'This is the ZikulaFooHookModule uiView Display Hook Response.'));
    }

    public function uiEdit(DisplayHook $hook)
    {
        $hook->setResponse(new DisplayHookResponse(HookContainer::PROVIDER_UIAREANAME, '<div>ZikulaFooModuleContent hooked.</div><input name="zikulafoomodule[name]" value="zikula" type="hidden">'));
    }

    public function validateEdit(ValidationHook $hook)
    {
        $post = $this->requestStack->getCurrentRequest()->request->all();
        if ($post['name'] == 'zikula') {
            return true;
        } else {
            $response = new ValidationResponse('name',['name' => 'Name must be Zikula']);
            $hook->setValidator('zikulafoomodule', $response);

            return false;
        }
    }

    public function processEdit(ProcessHook $hook)
    {
        $x = 1;
        $this->requestStack->getMasterRequest()->getSession()->getFlashBag()->add('success', 'hook properly processed!');
    }

    public function filter(FilterHook $hook)
    {
        $content = $hook->getData();
        $hook->setData('PRE ' . $content . ' POST');
    }
}
