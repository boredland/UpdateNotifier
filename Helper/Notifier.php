<?php

namespace Kanboard\Plugin\UpdateNotifier\Helper;

use Kanboard\Core\Base;
use Kanboard\Core\Plugin\Directory;
use Kanboard\Controller\PluginController;

class Notifier extends Base 
{
    public function renderUpdatePlugin()
    {
        $installed_plugins = array();

        foreach ($this->pluginLoader->getPlugins() as $plugin) {
            $installed_plugins[strtolower($plugin->getPluginName())] = array('version' => $plugin->getPluginVersion());
            
        }

        $available_plugins = Directory::getInstance($this->container)->getAvailablePlugins();
        
        foreach ($available_plugins as $key => $plugin) {
            unset($available_plugins[$key]['title']);
            unset($available_plugins[$key]['author']);
            unset($available_plugins[$key]['license']);
            unset($available_plugins[$key]['description']);
            unset($available_plugins[$key]['homepage']);
            unset($available_plugins[$key]['readme']);
            unset($available_plugins[$key]['download']);
            unset($available_plugins[$key]['remote_install']);
            unset($available_plugins[$key]['compatible_version']);
        }

        foreach($installed_plugins as $key => $value) {
            if ($installed_plugins[$key]['version'] < $available_plugins[$key]['version']) {
                $message = "New update: " . ucfirst($key) ." v". $available_plugins[$key]['version'];
                $anchorLink = ucfirst($key); 
                return '<a href="?controller=PluginController&action=directory#'.$anchorLink.'">' . $message . '</a>';
            }
        } 
    }

    public function renderUpdatekanboard()
    {
        $xml = simplexml_load_file('https://github.com/kanboard/kanboard/releases.atom');

        if ($xml) {
            $i = 0;
            $length = count($xml->entry);
            foreach($xml->entry as $value) {
                if ($i == 0) {
                    if (APP_VERSION < substr($value->title, 9)) {
                        return '<a href="https://github.com/kanboard/kanboard/releases" target="_blank">' . "New version: " . $value->title . '</a> | ';
                    }

                    $i++;
                }
            }
        }
    }
}