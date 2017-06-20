<?php

namespace Zikula\FooHookModule;

use Zikula\Core\AbstractExtensionInstaller;

class FooHookModuleInstaller extends AbstractExtensionInstaller
{
    public function install()
    {
        $this->hookApi->installSubscriberHooks($this->bundle->getMetaData());
        $this->hookApi->installProviderHooks($this->bundle->getMetaData());

        return true;
    }

    public function upgrade($oldversion)
    {
        return true;
    }

    public function uninstall()
    {
        $this->hookApi->uninstallSubscriberHooks($this->bundle->getMetaData());
        $this->hookApi->uninstallProviderHooks($this->bundle->getMetaData());
        return true;
    }
}
