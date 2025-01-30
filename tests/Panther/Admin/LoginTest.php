<?php
namespace Tests\Panther\Admin;

use Tests\Panther\Admin\AbstractBaseAdminPanther;

class LoginTest extends AbstractBaseAdminPanther
{


    public function testLogin(): void
    {

        $this->login();

    }
}
