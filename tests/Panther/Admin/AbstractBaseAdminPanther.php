<?php
namespace Tests\Panther\Admin;

use Facebook\WebDriver\WebDriverDimension;
use Symfony\Component\Panther\PantherTestCase;
use Tests\DataFixtures\LoadUser;

abstract class AbstractBaseAdminPanther extends PantherTestCase
{
    const EMAIL = LoadUser::EMAIL;
    const PASSWORD = LoadUser::PASSWORD;
    private const LIBELLE_PRESENTATION_ADMIN = 'Un Cms complet';
    private const PRESENTATION_SELECTOR = '#cms_complet';
    private const ID_SHEETS = '#Menus';
    private const ID_SHEET = '#Menu';
    protected const SHEETS = [
        'Menu1',
        'Menu2',
        'Menu3',
        'Contact',
    ];

    protected const MENUS = [
        self::SHEETS[0] =>  [
            'SousMenu11',
            'SousMenu12',
            'SousMenu13',
        ],
        self::SHEETS[1] =>  [
            'SousMenu21',
            'SousMenu22',
            'SousMenu23',
        ],
        self::SHEETS[2] =>  [
            'SousMenu31',
            'SousMenu32',
            'SousMenu33',
        ],
        self::SHEETS[3] =>  [
            'Contact'
        ],
    ];

	public static $client;
    public static $translator;

    protected function setUp(): void
    {
        static::$translator = static::getContainer()->get('translator');
    }

    protected function login($username = self::EMAIL, $password = self::PASSWORD, $bFollow = true, $url = "/fr/login", $submit = "Se connecter")
    {
        $client = static::createPantherClient(['browser' => static::FIREFOX]);
        $size = new WebDriverDimension(1024,10000);
        $client->manage()->window()->setSize($size);

        $crawler = $client->request('GET', '/fr/login');
        $this->assertPageTitleContains("Admin");
        // ... or the one provided by Panther
        $this->assertSelectorExists('[type="submit"]');

        $form = $crawler->filter('form')->form(
            [
                '_username' =>  LoadUser::EMAIL,
                '_password' =>  LoadUser::PASSWORD,
            ]
        );
        $client->submit($form);
        $client->waitFor(self::PRESENTATION_SELECTOR); // Wait for the comments to appear

        self::assertSelectorTextContains(self::PRESENTATION_SELECTOR,self::LIBELLE_PRESENTATION_ADMIN);

        return $client;

    }

    protected function sheet($sheet){

        // Test menu
    	$translator = static::$translator;
        $client = $this->login();
        $crawler = $client->request('GET', '/fr/admin/page/');

        self::assertSelectorTextContains(self::ID_SHEETS, 'Menus');

        $creer = $translator->trans('global.new');
        $client->clickLink($creer);
        $crawler = $client->refreshCrawler();

        self::assertSelectorTextContains(self::ID_SHEET, 'Menu');

        $this->assertSelectorExists('[type="submit"]');

        $crawler->filter('form')->form(
            [
                'sheet[name]' =>  $sheet,
            ]
        );

        $crawler->filter("[type='submit']")->eq(1)->click();

    }


    protected function menu($menu,$sheetId=1){

        // Test menu
    	$translator = static::$translator;
        $client = $this->login();
        $crawler = $client->request('GET', '/fr/admin/menu');

        $liste = $translator->trans('menu.list');

        self::assertSelectorTextContains("#sous_menus" , $liste);

        $creer = $translator->trans('global.new_menu');
        $client->clickLink($creer);
        $crawler = $client->refreshCrawler();

        // self::assertSelectorTextContains(self::MENU, 'Menu');

        $this->assertSelectorExists('[type="submit"]');

        $crawler->filter('form')->form(
            [
                'base_menu[sheet]' =>  $sheetId, //select2-base_menu_sheet-container
                'base_menu[name]' =>  $menu, //select2-base_menu_sheet-container
            ]
        );

        $crawler->filter("[type='submit']")->eq(0)->click();

    }

    protected function addMenuContent($sousmenu, $name , $type_template=1,  $content= "hello world" ){

        // Test menu
    	$translator = static::$translator;
        $client = $this->login();
        $crawler = $client->request('GET', '/fr/admin/menu');

        $liste = $translator->trans('menu.list');

        self::assertSelectorTextContains("#sous_menus" , $liste);

        $creer = $translator->trans('global.new_menu');
        $crawler->filter("#$sousmenu")->eq(0)->click();

        $crawler = $client->refreshCrawler();

        $this->assertSelectorExists('[type="submit"]');

        $array_form['section_template[posts][0][name]'] =  $name;

        if($type_template != 1){
            $array_form['section_template[template]'] =  $type_template;
        }

        $crawler->filter('form')->form(
            $array_form
        );

        if($type_template == 1){
            $crawler->filter(".ck-content")->eq(0)->sendKeys($content);
        }

        $crawler->filter("[type='submit']")->eq(1)->click();

    }


}
