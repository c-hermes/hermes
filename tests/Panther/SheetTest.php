<?php
namespace App\Tests\Panther;

use Tests\Panther\AbstractBasePantherTest;

class SheetTest extends AbstractBasePantherTest
{


    public function testMenu(): void
    {

        foreach(self::SHEETS as $sheet){
            $this->sheet($sheet);
        }

    }
}
