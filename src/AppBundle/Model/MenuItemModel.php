<?php
/**
 * Created by PhpStorm.
 * User: iibarguren
 * Date: 16/04/18
 * Time: 9:19
 */

namespace AppBundle\Model;


use Avanzu\AdminThemeBundle\Model\MenuItemInterface as ThemeMenuItem;

class MenuItemModel implements ThemeMenuItem {
    // ...
    // implement interface methods
    // ...

    /**
     * @return mixed
     */
    public function getIdentifier()
    {
        // TODO: Implement getIdentifier() method.
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        // TODO: Implement getLabel() method.
    }

    /**
     * @return mixed
     */
    public function getRoute()
    {
        // TODO: Implement getRoute() method.
    }

    /**
     * @return mixed
     */
    public function isActive()
    {
        // TODO: Implement isActive() method.
    }

    /**
     * @param $isActive
     *
     * @return mixed
     */
    public function setIsActive( $isActive )
    {
        // TODO: Implement setIsActive() method.
    }

    /**
     * @return mixed
     */
    public function hasChildren()
    {
        // TODO: Implement hasChildren() method.
    }

    /**
     * @return mixed
     */
    public function getChildren()
    {
        // TODO: Implement getChildren() method.
    }

    /**
     * @param ThemeMenuItem $child
     *
     * @return mixed
     */
    public function addChild( ThemeMenuItem $child )
    {
        // TODO: Implement addChild() method.
    }

    /**
     * @param ThemeMenuItem $child
     *
     * @return mixed
     */
    public function removeChild( ThemeMenuItem $child )
    {
        // TODO: Implement removeChild() method.
    }

    /**
     * @return mixed
     */
    public function getIcon()
    {
        // TODO: Implement getIcon() method.
    }

    /**
     * @return mixed
     */
    public function getBadge()
    {
        // TODO: Implement getBadge() method.
    }

    /**
     * @return mixed
     */
    public function getBadgeColor()
    {
        // TODO: Implement getBadgeColor() method.
    }

    /**
     * @return mixed
     */
    public function getParent()
    {
        // TODO: Implement getParent() method.
    }

    /**
     * @return mixed
     */
    public function hasParent()
    {
        // TODO: Implement hasParent() method.
    }

    /**
     * @param ThemeMenuItem $parent
     *
     * @return mixed
     */
    public function setParent( ThemeMenuItem $parent = null )
    {
        // TODO: Implement setParent() method.
    }

    /**
     * @return ThemeMenuItem|null
     */
    public function getActiveChild()
    {
        // TODO: Implement getActiveChild() method.
    }
}