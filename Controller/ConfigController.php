<?php

namespace Zikula\FooHookModule\Controller;

use Zikula\Core\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Zikula\ThemeModule\Engine\Annotation\Theme;

/**
* @Route("/config")
 */
class ConfigController extends AbstractController
{
    /**
     * @Route("/settings")
     * @Theme("admin")
     * @Template()
     */
    public function settingsAction(Request $request)
    {
        return [];
    }
}
