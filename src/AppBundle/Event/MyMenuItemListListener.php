<?php
/**
 * Created by PhpStorm.
 * User: iibarguren
 * Date: 16/04/18
 * Time: 9:21
 */

namespace AppBundle\Event;


use Avanzu\AdminThemeBundle\Event\KnpMenuEvent;

class MyMenuItemListListener {

    public function onSetupMenu(KnpMenuEvent $event)
    {
        $menu = $event->getMenu();

        // Adds a menu item which acts as a label
        $menu->addChild('MainNavigationMenuItem', [
                                                    'label' => 'MAIN NAVIGATION',
                                                    'childOptions' => $event->getChildOptions()
                                                ]
        )->setAttribute('class', 'header');

        // A "regular" menu item with a link
        $menu->addChild('TestMenuItem', [
                                          'route' => 'homepage',
                                          'label' => 'Donibane',
                                          'childOptions' => $event->getChildOptions()
                                      ]
        )->setLabelAttribute('icon', 'fa fa-flag');

        // Adds a menu item which has children
        $menu->addChild('Barrutiak', [
                                          'label' => 'Barrutiak',
                                          'childOptions' => $event->getChildOptions()
                                      ]
        )->setLabelAttribute('icon', 'fa fa-database');
        // First child, a regular menu item
        $menu->getChild('Barrutiak')->addChild('DataUsersMenuItem', [
//                                                                         'route' => 'app.database.users',
                                                                         'label' => 'Donibane',
                                                                         'childOptions' => $event->getChildOptions()
                                                                     ]
        )->setLabelAttribute('icon', 'fa fa-user');
        // Second child, a regular menu item
        $menu->getChild('Barrutiak')->addChild('DataGroupsMenuItem', [
//                                                                          'route' => 'app.database.groups',
                                                                          'label' => 'Antxo',
                                                                          'childOptions' => $event->getChildOptions()
                                                                      ]
        )->setLabelAttribute('icon', 'fa fa-users');
    }

}