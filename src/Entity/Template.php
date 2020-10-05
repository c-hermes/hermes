<?php

namespace App\Entity;

use App\Entity\Traits\ActiveTrait;
use App\Entity\Traits\CodeTrait;
use App\Entity\Traits\IdTrait;
use App\Entity\Traits\NameTrait;
use App\Entity\Traits\SummaryTrait;
use App\Entity\Traits\TemplateTrait;
use App\Entity\Section;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ORM\Table(name="template")
 * Defines the properties of the Sheet entity to represent the blog menus.
 *
 * See https://symfony.com/doc/current/book/doctrine.html#creating-an-entity-class
 *
 * Tip: if you have an existing database, you can generate these entity class automatically.
 * See https://symfony.com/doc/current/cookbook/doctrine/reverse_engineering.html
 *
 * @author Ryan Weaver <weaverryan@gmail.com>
 * @author Javier Eguiluz <javier.eguiluz@gmail.com>
 * @author Yonel Ceruto <yonelceruto@gmail.com>
 */
class Template
{
    use IdTrait;
    use ActiveTrait;
    use CodeTrait;
    use NameTrait;
    use SummaryTrait;

    /**
     * @var Section[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Section", mappedBy="template",  cascade={"persist", "remove"})
     * @ORM\JoinTable(name="section_template")
     */
    private $sections;

    /**
     * Template constructor.
     */
    public function __construct()
    {
        $this->sections = new ArrayCollection();
    }

    public function __toString(): ?string
    {
        if(!is_null($this->name)){
            return $this->name;
        }
        return '';
    }

    public function __get($prop)
    {
        return $this->$prop;
    }

    public function __isset($prop) : bool
    {
        return isset($this->$prop);
    }

    public function addSection(?Section ...$sections): void
    {
        foreach ($sections as $section) {
            if (!$this->sections->contains($section)) {
                if($section->isActive()){
                    $this->sections->add($section);
                }
            }
        }
    }

    public function removeSection(Section $section): void
    {
        $this->sections->removeElement($section);
        $section->setSection(null);
    }

    public function getSections(): ?Collection
    {
        foreach ($this->sections as $section){
            if(!$section->isActive()){
                $this->removeSection($section);
            }
        }
        return $this->sections;
    }

}
