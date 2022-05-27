<?php

namespace App\Repository;

use App\Entity\Post;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Post::class);
    }

    // /**
    //  * @return Post[] Returns an array of Post objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Post
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function feed($value)
    {
        return $this->createQueryBuilder('p')
            ->join('p.autor' , 'u')
            //se coge el campo que hace de union entre ambas tablas, y este u es el alias que se le pone a la tabla 
            //que se va a relacionar
            ->join('u.followers' , 'f')
            //ahora este usuario tiene que estar en la otra tabla follower
            ->andWhere('f.id = :val')
            //ese follower debo ser yo, para ver sus post, por lo que el id es el de mi usuario
            ->setParameter('val', $value->getId())
            //es mejor pasar el objeto user entero y aqui coger su id
            ->orderBy('p.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }

    public function findImgById($value): ?Post
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.id = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }

    public function fiveIdPostLikes()
    {//tienen que salir: kuiil (3), gem(2), battlefront2 (2), clone wars(2), visas(2)
        return $this->createQueryBuilder('p')
            ->select('p') //desde aqui no puedo acceder al numero de likes, hacer otra consulta con count(p)
            ->join('p.likes' , 'u') //aqui es donde se une con el atributo-relacion likes, ManyToMany, entre post y user
            ->groupBy('p.id')
            ->orderBy('count(p)', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
        ;
    }

    public function fiveNumberPostLikes()
    {
        return $this->createQueryBuilder('p')
            ->select('count(p)')
            ->join('p.likes' , 'u')
            ->groupBy('p.id')
            ->orderBy('count(p)', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
        ;
    }

    public function fiveIdPostComments()
    {//tienen que salir: kotor2(2), battlefront2(2), anakin-padme(2), gem(2), visas(3)
        return $this->createQueryBuilder('p')
            ->select('p')
            ->join('p.comments' , 'c')
            ->groupBy('p.id')
            ->orderBy('count(p)', 'DESC')
            ->setMaxResults(5) //de poner 6 el siguiente tiene 1 comentario
            ->getQuery()
            ->getResult()
        ;
    }

    public function fiveNumberPostComments(){
        return $this->createQueryBuilder('p')
            ->select('count(p)')
            ->join('p.comments' , 'c')
            ->groupBy('p.id')
            ->orderBy('count(p)', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
        ;
    }

    public function postsUltimaSemana($val){
        return $this->createQueryBuilder('p')
            ->select('p')
            ->andWhere('p.time > :val')
            ->setParameter('val', $val)
            ->getQuery()
            ->getResult()
        ;
    }
}
