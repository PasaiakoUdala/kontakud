<?php

/*
 *     Iker Ibarguren <@ikerib>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace AppBundle\Menu;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityManager;
use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;

class Builder implements ContainerAwareInterface
{

    use ContainerAwareTrait;

    public function mainMenu( FactoryInterface $factory, array $options )
    {
        $menu = $factory->createItem( 'root', [ 'navbar' => true ] );

        $menu->addChild( 'Taula Laguntzaileak', [ 'icon' => 'th-list' ] );
        $menu['Taula Laguntzaileak']->addChild('Kanalak', ['icon' => 'road', 'route' => 'admin_kanala_index']);
        $menu['Taula Laguntzaileak']->addChild('Barrutiak', ['icon' => 'globe', 'route' => 'admin_barrutia_index']);
        $menu['Taula Laguntzaileak']->addChild('divider', ['divider' => true]);
        $menu['Taula Laguntzaileak']->addChild('Tramiteen emaitza motak', ['icon' => 'saved', 'route' => 'admin_result_index']);
        $menu['Taula Laguntzaileak']->addChild('Tramiteen motak', ['icon' => 'tag', 'route' => 'admin_mota_index']);


        return $menu;
    }

    public function userMenu( FactoryInterface $factory, array $options )
    {
        $checker = $this->container->get( 'security.authorization_checker' );
        /** @var $user User */
        $user = $this->container->get( 'security.token_storage' )->getToken()->getUser();

        $menu = $factory->createItem( 'root', [ 'navbar' => true, 'icon' => 'user' ] );

        if ( $checker->isGranted( 'ROLE_USER' ) ) {

            $menu->addChild(
                'User',
                array(
                    'label'    => $user->getDisplayname() . " ( ".$user->getBarrutia()." )",
                    'dropdown' => true,
                    'icon'     => 'user',
                )
            );
            $menu['User']->addChild('Aldatu barrutia', ['icon' => 'globe', 'route' => 'barrutia']);


        } else {
            $menu->addChild( 'login', [ 'route' => 'fos_user_security_login' ] );
        }


        return $menu;
    }
}


