<?php

namespace Zikula\FooHookModule;

use Zikula\Core\AbstractExtensionInstaller;

class FooHookModuleInstaller extends AbstractExtensionInstaller
{
    public function install()
    {
        return true;
    }

    public function upgrade($oldversion)
    {
        return true;
    }

    public function uninstall()
    {
        return true;
    }
}
