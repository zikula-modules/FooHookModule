<?php

namespace Zikula\FooHookModule\Block;

use Zikula\BlocksModule\BlockHandlerInterface;

/**
 * Example block to demonstrate a 'bare bones' block requiring only the interface.
 */
class FooHookModuleBlock implements BlockHandlerInterface
{
    public function getType()
    {
        return 'FooHookModule';
    }

    public function display(array $properties)
    {
        return "<div><strong>FooHookModule Block!</strong></div>";
    }

    public function getFormClassName()
    {
        return null;
    }

    public function getFormTemplate()
    {
        return '';
    }

    public function getFormOptions()
    {
        return [];
    }
}
