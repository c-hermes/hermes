<?php
namespace App\Tests\Panther;

use Tests\Panther\AbstractBasePantherTest;

class MenuTest extends AbstractBasePantherTest
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
