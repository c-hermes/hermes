<?php

namespace App\Repository;

use App\Entity\Hermes\Menu;
use App\Entity\Hermes\Section;
use App\Repository\Traits\BaseRepositoryTrait;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry as RegistryInterface;

/**
 * @method Section|null find($id, $lockMode = null, $lockVersion = null)
 * @method Section|null findOneBy(array $criteria, array $orderBy = null)
 * @method Section[]    findAll()
 * @method Section[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SectionRepository extends ServiceEntityRepository
{
    use BaseRepositoryTrait;

    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Section::class);
    }

    public function getArrayResults(){
        $results = $this->createQueryBuilder('s')
        ->orderBy('s.menu', 'ASC')
        ->addOrderBy('s.position', 'ASC')
        ->addOrderBy('s.active', 'DESC')
        ->getQuery()
        ->getResult();
        foreach($results as $key => $result){
            if(!is_null($result->getMenu()) ){
                $sections[$key]['id'] = $result->getId();
                $sections[$key]['active'] = $result->isActive();
                $sections[$key]['position'] = $result->getPosition();
                $sections[$key]['name'] = $result->getName();
                foreach($result->getPosts() as $kp => $post){
                    $sections[$key]['posts'][$kp]['id'] = $post->getId();
                    $sections[$key]['posts'][$kp]['name'] = $post->getName();
                    $sections[$key]['posts'][$kp]['isActive'] = $post->isActive();
                    $sections[$key]['posts'][$kp]['post_position'] = $post->getPosition();
                }
                $sections[$key]['template'] = $result->getTemplate()->getName();
                $sections[$key]['template_code'] = $result->getTemplate()->getCode();
                $sections[$key]['menu_id'] = $result->getMenu()->getId();
                $sections[$key]['menu_slug'] = $result->getMenu()->getSlug();
                $sections[$key]['menu'] = $result->getMenu()->getName();
                $sections[$key]['locale'] = $result->getMenu()->getLocale();
                $sections[$key]['sheet'] = $result->getMenu()->getSheet()->getName();
            }
        }
       
        return array_values($sections);

    }


    /**
     * @return int Returns max position value for a given Menu
     */
     public function getMaxPosition(Menu $menu)
     {
         $qb = $this->getQbMaxPosition();
         if (isset($menu)) {
             $qb
                 ->where('m.menu = :menu')
                 ->setParameter(':menu', $menu->getId());
         }
         $list = $qb
             ->getQuery()
             ->getResult();
 
         if (isset($list[0])) {
             return ++$list[0]['position'];
         }
         if (isset($list['position'])) {
             return ++$list['position'];
         }
         return 1;
     }

}
