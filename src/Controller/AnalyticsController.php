<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/analytics")
 */
class AnalyticsController extends AbstractController
{
    /**
     * @Route("/", name="analytics", methods={"GET"})
     */
    public function analytics(UserRepository $userRepo, PostRepository $postRepo): Response
    {
        $totalUsers = count($userRepo->findAll());
        $totalPosts = count($postRepo->findAll());

        //LIKES

        //Obtener id de los 5 posts con mas likes

        $arrayIdPostLikes = array();
        $fiveIdPostLikes = $postRepo->fiveIdPostLikes();
        foreach ($fiveIdPostLikes as $key => $value) {
            $arrayIdPostLikes[] = $value->getId();    
        }
        //dump($arrayIdPostLikes);
        
        //Obtener numero de likes de los 5 posts

        $arrayNumberPostLikes = array();
        $fiveNumberPostLikes = $postRepo->fiveNumberPostLikes();
        foreach ($fiveNumberPostLikes as $key => $value) {
            foreach ($value as $key2 => $value2) {
                $arrayNumberPostLikes[] = $value2;
            }
        }
        //dump(json_encode($arrayNumberPostLikes));
        //exit;
        
        //COMENTARIOS
        
        //Obtener id de los 5 posts con mas comentarios

        $arrayIdPostComments = array();
        $fiveIdPostComments = $postRepo->fiveIdPostComments();
        foreach ($fiveIdPostComments as $key => $value) {
            $arrayIdPostComments[] = $value->getId();
            
        }
        //dump($arrayIdPostComments);

        //Obtener numero de comentarios de los 5 posts

        $arrayNumberPostComments = array();
        $fiveNumberPostComments = $postRepo->fiveNumberPostComments();
        foreach ($fiveNumberPostComments as $key => $value) {
            foreach ($value as $key2 => $value2) {
                $arrayNumberPostComments[] = $value2;
            }
        }

        //dump($arrayNumberPostComments);
        //exit;


        //Post creados la ultima semana (ya que todos son del ultim mes)
        $ultimaSemana = new \DateTime();
        $ultimaSemana->modify("-1 week"); //para obtener la semana anterior

        $postsUltimaSemana = $postRepo->postsUltimaSemana($ultimaSemana);

        return $this->render('analytics/analytics.html.twig', [
            'totalUsers' => $totalUsers,
            'totalPosts' => $totalPosts,
            'idPostLikes' => $arrayIdPostLikes,
            'numberPostLikes' => $arrayNumberPostLikes,
            'idPostComments' => $arrayIdPostComments,
            'numberPostComments' => $arrayNumberPostComments,
            'postsUltimaSemana' => $postsUltimaSemana
        ]);
    }

}