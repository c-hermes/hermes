<?php
namespace App\Tests\Panther\Admin;

use Tests\Panther\Admin\AbstractBaseAdminPanther;

class MenuTest extends AbstractBaseAdminPanther
{
    public function testMenu(): void
    {
        $k=1;
        foreach(self::MENUS as $menus){
            foreach($menus as $menu){
                $this->menu($menu, $k);
            }
            $k++;
        }
    }
}
