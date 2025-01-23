<?php
namespace App\Tests\Panther;

use Tests\Panther\AbstractBasePantherTest;

class SectionTest extends AbstractBasePantherTest
{
    public function testAddMenuContent(): void
    {
        $sousmenu= self::MENUS[self::SHEETS[0]][0];
        $name = 'test';
        $content = 'Test Content';
        $this->addMenuContent($sousmenu, $name , 1 , $content);
    }

    public function testAddMenuContact(): void
    {
        $sousmenu= self::MENUS[self::SHEETS[3]][0];
        $name = 'test contact';
        $this->addMenuContent($sousmenu, $name , 3 , null);
    }

}
