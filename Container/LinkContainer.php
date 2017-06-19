<?php

namespace Zikula\FooHookModule\Container;

use Symfony\Component\Routing\RouterInterface;
use Zikula\Common\Translator\TranslatorInterface;
use Zikula\Core\LinkContainer\LinkContainerInterface;
use Zikula\PermissionsModule\Api\ApiInterface\PermissionApiInterface;

/**
 * This is the class that manages your module links
 */
class LinkContainer implements LinkContainerInterface
{
    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var PermissionApiInterface
     */
    private $permissionApi;

    /**
     * LinkContainer constructor.
     * @param TranslatorInterface $translator
     * @param RouterInterface $router
     * @param PermissionApiInterface $permissionApi
     */
    public function __construct(
        TranslatorInterface $translator,
        RouterInterface $router,
        PermissionApiInterface $permissionApi
    ) {
        $this->translator = $translator;
        $this->router = $router;
        $this->permissionApi = $permissionApi;
    }

    public function getLinks($type = LinkContainerInterface::TYPE_ADMIN)
    {
        $links = [];
        $links[] = [
            'url' => $this->router->generate('zikulafoohookmodule_default_index'),
            'text' => $this->translator->__('Front End View'),
            'icon' => 'eye'
        ];
        $links[] = [
            'url' => $this->router->generate('zikulafoohookmodule_default_foo'),
            'text' => $this->translator->__('Foo form'),
            'icon' => 'square'
        ];

        if (LinkContainerInterface::TYPE_ADMIN == $type) {
            if ($this->permissionApi->hasPermission('ZikulaFooHookModule::', '::', ACCESS_ADMIN)) {
                $links[] = [
                    'url' => $this->router->generate('zikulafoohookmodule_config_settings'),
                    'text' => $this->translator->__('Modify Config'),
                    'icon' => 'wrench'
                ];
            }
        }

        return $links;
    }

    public function getBundleName()
    {
        return 'ZikulaFooHookModule';
    }
}
