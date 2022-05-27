<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\PostRepository;
use App\Repository\UserRepository;
use App\Repository\ReportRepository;
use Symfony\Component\HttpFoundation\Request;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index(PostRepository $repoPost, ReportRepository $repoRepost): Response
    {
        if($this->isGranted("ROLE_USER")){

            $listaPosts = $repoPost->feed($this->getUser());

            if($this->isGranted("ROLE_ADMIN")){
                $numberReports = $repoRepost->numberReports();
                return $this->render('main/index.html.twig', [
                    'controller_name' => 'MainController',
                    'posts' => $listaPosts,
                    'usuario' => $this->getUser(),
                    'numberReports' => $numberReports
                ]);

            }else{
                
                return $this->render('main/index.html.twig', [
                    'controller_name' => 'MainController',
                    'posts' => $listaPosts,
                    'usuario' => $this->getUser()
                ]);
            }
            
        }
            
        else
            return $this->redirectToRoute('app_login');
    }

    /**
     * @Route("/search", name="search")
     */
    public function search(Request $request, UserRepository $repoUser): Response
    {
        $text = $request->get('searchField');

        $listUser = $repoUser->search($text);

        return $this->render('user/list.html.twig', [
            'listUser' => $listUser
        ]);
    }
}
