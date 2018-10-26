<?php

namespace Kanboard\Plugin\UpdateNotifier;

use Kanboard\Core\Plugin\Base;

class Plugin extends Base
{

    public function initialize()
    {
        $this->helper->register('Notifier', 'Kanboard\Plugin\UpdateNotifier\Helper\Notifier');
        $this->template->hook->attach('template:layout:top', 'UpdateNotifier:layout/top');
        $this->template->setTemplateOverride('plugin/directory', 'UpdateNotifier:plugin/directory');
        $this->hook->on("template:layout:css", array("template" => "plugins/UpdateNotifier/Assets/css/notifier.css"));
    }
  
    public function getPluginName()
    {
        return 'Update Notifier';
    }

    public function getPluginDescription()
    {
        return t('What is Update Notifier? The Update Notifier is a utility that scans installed plugin and displays a list of updates.');
    }

    public function getPluginAuthor()
    {
        return 'Valentino Pesce';
    }

    public function getPluginVersion()
    {
        return '1.1.0';  
    }

    public function getCompatibleVersion()
    {
        return '>=1.2.5';
    }

    public function getPluginHomepage()
    {
        return 'https://github.com/kenlog/UpdateNotifier';
    }

}