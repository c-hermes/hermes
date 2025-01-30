<?php
namespace Tests\Panther\Front;

use Facebook\WebDriver\WebDriverDimension;
use Symfony\Component\Panther\PantherTestCase;

abstract class AbstractBaseFrontPanther extends PantherTestCase
{
    const NOM = 'John';
    const PRENOM = 'Doe';
    const EMAIL = 'johndoe@test.com';
    const TELEPHONE = '0611223344';
    const MESSAGE = 'Test Message';

    private const URL_CONTACT = '/fr/contact';
    private const SELECTOR_FORM_CONTACT = "form#form_contact";

    // private const SEND_MESSAGE_SELECTOR = '#sendMessageButton';
    // private const SEND_MESSAGE_VALUE = 'Envoyer';

    private const SEND_MESSAGE_SELECTOR = '#send_message';
    private const SEND_MESSAGE_VALUE = 'Votre message a bien été envoyé';
	public static $client;
    public static $translator;

    protected function setUp(): void
    {
        static::$translator = static::getContainer()->get('translator');
    }

    protected function contact()
    {
        $client = static::createPantherClient(['browser' => static::FIREFOX]);
        $size = new WebDriverDimension(1024,10000);
        $client->manage()->window()->setSize($size);

        $crawler = $client->request('GET', self::URL_CONTACT);
        //$this->assertPageTitleContains("Contact");
        // ... or the one provided by Panther
        $this->assertSelectorExists('[type="submit"]');

        $form = $crawler->filter(self::SELECTOR_FORM_CONTACT)->form(
            [
                "contact[firstname]" =>  self::NOM,
                "contact[lastname]" =>  self::PRENOM,
                "contact[email]" =>  self::EMAIL,
                "contact[telephone]" =>  self::TELEPHONE,
                "contact[content]" =>  self::MESSAGE,
            ]
        );

        $client->submit($form);
        $crawler = $client->refreshCrawler();

        $client->waitFor(self::SEND_MESSAGE_SELECTOR); // Wait for the comments to appear

        self::assertSelectorTextContains(self::SEND_MESSAGE_SELECTOR,self::SEND_MESSAGE_VALUE);

    }

}
