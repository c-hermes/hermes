<?php

namespace Tests\DataFixtures;

use App\Entity\Hermes\Template;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class LoadTemplate extends Fixture  implements FixtureGroupInterface
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
        $templates = $configurations['template'];

        foreach ($templates as $i => $value) {
            $item = new Template();
            $item->setActive(true);
            $item->setType($value['type']);
            $item->setCode($value['code']);
            $item->setName($value['name']);
            $item->setSummary($value['summary']);

            $code = $value['code'];
            $this->addReference("$code", $item);
            $manager->persist($item);
        }
        $manager->flush();

    }

    public static function getGroups(): array
    {
        return ['default', 'templates'];
    }

}
