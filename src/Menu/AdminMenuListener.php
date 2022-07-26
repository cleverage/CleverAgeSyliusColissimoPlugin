<?php

namespace CleverAge\SyliusColissimoPlugin\Menu;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class AdminMenuListener
{
    public function __invoke(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();

        $newSubMenu = $menu
            ->addChild('Colissimo')
            ->setLabel('clever_age.admin.ui.colissimo_parameter.menu.title');

        $newSubMenu
            ->addChild('colissimo_parameter', ['route' => 'admin_settings_colissimo_parameter'])
            ->setLabel('clever_age.admin.ui.colissimo_parameter.menu.label')
            ->setLabelAttribute('icon', 'cog');
    }
}
