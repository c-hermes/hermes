<?php

namespace Tests\DataFixtures;

use App\Entity\Config\Config;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class LoadConfig extends Fixture  implements FixtureGroupInterface
{
    /**
     * @var ParameterBagInterface
     */
    private $params;

    public function setParams(ParameterBagInterface $parameterBagInterface = null)
    {
        $this->params = $parameterBagInterface;

    }
    public function load(ObjectManager $manager): void
    {
        $configurations = $this->params->get('init');

        $config = $configurations['config'];

        foreach ($config as $type => $value) {
            foreach($value as $code => $conf){
                $item = new Config();
                $value = !is_null($conf['value']) ? $conf['value'] : '';
                $item->setPosition($conf['position']);
                $item->setType($type);
                $item->setCode($code);
                $item->setValue($value);
                $item->setSummary($conf['summary']);

                $this->addReference("$type'-'$code" , $item);
                $manager->persist($item);
            }
            $manager->flush();
        }



    }

    public static function getGroups(): array
    {
        return ['config'];
    }

}
