<?php
namespace App\Tests\Panther\Admin;

use Tests\Panther\Admin\AbstractBaseAdminPanther;

class SheetTest extends AbstractBaseAdminPanther
{


    public function testMenu(): void
    {

        foreach(self::SHEETS as $sheet){
            $this->sheet($sheet);
        }

    }
}
