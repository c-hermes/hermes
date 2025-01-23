<?php
namespace Tests\Panther;

use Tests\Panther\AbstractBasePantherTest;

class LoginTest extends AbstractBasePantherTest
{


    public function testLogin(): void
    {

        $this->login();

        // $client = static::createPantherClient(['browser' => static::FIREFOX]);
        // $size = new WebDriverDimension(1024,10000);
        // $client->manage()->window()->setSize($size);

        // $crawler = $client->request('GET', '/fr/login');
        // $this->assertPageTitleContains("Admin");
        // // ... or the one provided by Panther
        // $this->assertSelectorExists('[type="submit"]');

        // $form = $crawler->filter('form')->form(
        //     [
        //         '_username' =>  LoadUser::EMAIL,
        //         '_password' =>  LoadUser::PASSWORD,
        //     ]
        // );
        // $client->submit($form);
        // $client->waitFor(self::PRESENTATION_SELECTOR); // Wait for the comments to appear

        // self::assertSelectorTextContains(self::PRESENTATION_SELECTOR, 'Un Cms complet');


 
    }
}
