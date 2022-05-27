<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use App\Repository\PostRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


/**
 * @Route("/user")
 */
class UserController extends AbstractController
{
    
    /**
     * @Route("/", name="user_index", methods={"GET"})
     
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }
    */
    
    /**
     * @Route("/new", name="user_new", methods={"GET", "POST"})
     
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(User1Type::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
        ]);
    }
    */

    

    /**
     * @Route("/{nombreUsuario}", name="user_show", methods={"GET"})
    */
    public function show(User $user): Response
    {
        $posts = $user->getTotalPosts();
        $followers = $user->getFollowers();
        $followed = $user->getFollowed();

        return $this->render('user/show.html.twig', [
            'usuario' => $user,
            'posts' => $posts,
            'followers' => $followers,
            'followed' => $followed
        ]);
    }
    
    /**
     * @Route("/{nombreUsuario}/followers", name="followers", methods={"GET"})
    */
    public function followers(User $user): Response
    {
        $listUser = $user->getFollowers();

        return $this->render('user/list.html.twig', [
            'usuario' => $user,
            'listUser' => $listUser
        ]);
    }

    /**
     * @Route("/{nombreUsuario}/followed", name="followed", methods={"GET"})
    */
    public function followed(User $user): Response
    {
        $listUser = $user->getFollowed();

        return $this->render('user/list.html.twig', [
            'usuario' => $user,
            'listUser' => $listUser
        ]);
    }

    /**
     * @Route("/{user}", name="user_show", methods={"GET"})
    
    public function show(UserRepository $userRepo, $user): Response
    {
        $objUser = $userRepo->findUserByName($user);
        $posts = $objUser->getTotalPosts();

        return $this->render('user/show.html.twig', [
            'usuario' => $objUser,
            'posts' => $posts
        ]);
    }
*/
    /**
     * @Route("/{nombreUsuario}/edit", name="user_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('user_show', ["nombreUsuario"=> $this->getUser()->getNombreUsuario()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form
        ]);
    }

    /**
     * @Route("/{id}/delete", name="user_delete", methods={"POST"})
     */
    public function delete(Request $request, User $user, EntityManagerInterface $entityManager, SessionInterface $session): Response
    {
        if ($this->isCsrfTokenValid('delete'.$user->getId(), $request->request->get('_token'))) {
            
            $this->get('security.token_storage')->setToken(null);
            
            $entityManager->remove($user);
            $entityManager->flush();

            $session->invalidate(0);
            
        }

        return $this->redirectToRoute('app_login', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/follow/{nombreUsuario}", name="follow_user", methods={"GET"})
     */
    public function follow(UserRepository $userRepo, EntityManagerInterface $entityManager, User $user): Response
    {
        //$objUser = $userRepo->findUserByName($user);
        $user->addFollower($this->getUser());
        
        $followers = $user->getFollowers();
        $followed = $user->getFollowed();

        $posts = $user->getTotalPosts();

        $entityManager->flush();

        return $this->renderForm('user/show.html.twig', [
            'usuario' => $user,
            'posts' => $posts,
            'followers' => $followers,
            'followed' => $followed
        ]);

    }

    /**
     * @Route("/unfollow/{nombreUsuario}", name="unfollow_user", methods={"GET"})
     */
    public function unfollow(UserRepository $userRepo, EntityManagerInterface $entityManager, User $user): Response
    {
        //$objUser = $userRepo->findUserByName($user);
        $user->removeFollower($this->getUser());
        
        $followers = $user->getFollowers();
        $followed = $user->getFollowed();

        $posts = $user->getTotalPosts();

        $entityManager->flush();

        return $this->renderForm('user/show.html.twig', [
            'usuario' => $user,
            'posts' => $posts,
            'followers' => $followers,
            'followed' => $followed
        ]);

    }


    

}
