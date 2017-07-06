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

use Symfony\Component\HttpFoundation\RequestStack;
use Zikula\Bundle\HookBundle\Category\UiHooksCategory;
use Zikula\Bundle\HookBundle\Hook\DisplayHook;
use Zikula\Bundle\HookBundle\Hook\DisplayHookResponse;
use Zikula\Bundle\HookBundle\Hook\ProcessHook;
use Zikula\Bundle\HookBundle\Hook\ValidationHook;
use Zikula\Bundle\HookBundle\Hook\ValidationResponse;
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
     * @var RequestStack
     */
    private $requestStack;

    /**
     * ProviderHandler constructor.
     * @param TranslatorInterface $translator
     */
    public function __construct(
        TranslatorInterface $translator,
        RequestStack $requestStack
    ) {
        $this->translator = $translator;
        $this->requestStack = $requestStack;
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
            UiHooksCategory::TYPE_DISPLAY_VIEW => ['uiView', 'display', 'display_more'],
            UiHooksCategory::TYPE_FORM_EDIT => 'uiEdit',
            UiHooksCategory::TYPE_VALIDATE_EDIT => 'validateEdit',
            UiHooksCategory::TYPE_PROCESS_EDIT => 'processEdit'
        ];
    }

    public function uiView(DisplayHook $hook)
    {
        $hook->setResponse(new DisplayHookResponse('provider.zikulafoohookmodule.ui_hooks.foo', 'This is the ZikulaFooHookModule uiView Display Hook Response.'));
    }

    public function display(DisplayHook $hook)
    {
        $hook->setResponse(new DisplayHookResponse('provider.zikulafoohookmodule.ui_hooks.foo', 'This is the FormAwareHookProvider display hook response'));
    }

    public function display_more(DisplayHook $hook)
    {
        $hook->setResponse(new DisplayHookResponse('provider.zikulafoohookmodule.ui_hooks.foo', 'This is a SECOND FormAwareHookProvider display_more hook response'));
    }

    public function uiEdit(DisplayHook $hook)
    {
        $hook->setResponse(new DisplayHookResponse('provider.zikulafoohookmodule.ui_hooks.foo', '<div>ZikulaFooModuleContent hooked.</div><input name="zikulafoomodule[name]" value="zikula" type="hidden">'));
    }

    public function validateEdit(ValidationHook $hook)
    {
        $post = $this->requestStack->getCurrentRequest()->request->all();
        if ($this->requestStack->getCurrentRequest()->request->has('zikulafoomodule') && $post['zikulafoomodule']['name'] == 'zikula') {
            return true;
        } else {
            $response = new ValidationResponse('mykey', $post['zikulafoomodule']);
            $response->addError('name', sprintf('Name must be zikula but was %s', $post['zikulafoomodule']['name']));
            $hook->setValidator('provider.zikulafoohookmodule.ui_hooks.foo', $response);

            return false;
        }
    }

    public function processEdit(ProcessHook $hook)
    {
        $this->requestStack->getMasterRequest()->getSession()->getFlashBag()->add('success', 'Ui hook properly processed!');
    }
}
