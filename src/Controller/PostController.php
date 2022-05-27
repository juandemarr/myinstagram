<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;

use App\Entity\Comment;
use App\Form\CommentType;
use App\Repository\CommentRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

use Symfony\Component\Filesystem\Filesystem;

/**
 * @Route("/post")
 */
class PostController extends AbstractController
{
    /**
     * @Route("/", name="post_index", methods={"GET"})
     
    public function index(PostRepository $postRepository): Response
    {
        return $this->render('post/index.html.twig', [
            'posts' => $postRepository->findAll(),
        ]);
    }
*/
    /**
     * @Route("/like/{post}", name="add_like", methods={"GET"})
     */
    public function addLike(Post $post, EntityManagerInterface $entityManager): Response
    {
        $post->addLike($this->getUser());
        
        $entityManager->persist($post);
        $entityManager->flush();

        return $this->redirectToRoute('post_show',["post"=> $post->getId()], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/remove_like/{post}", name="remove_like", methods={"GET"})
     */
    public function removeLike(Post $post, EntityManagerInterface $entityManager): Response
    {
        $post->removeLike($this->getUser());
        
        $entityManager->persist($post);
        $entityManager->flush();

        return $this->redirectToRoute('post_show',["post"=> $post->getId()], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/new", name="post_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, SluggerInterface $slugger): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imageFile = $form->get('foto')->getData();
            // this condition is needed because the field is not required
            // so the file must be processed only when a file is uploaded
            if ($imageFile) {
                $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);//slug quita simbolos raros
                $newFilename = $safeFilename.'-'.uniqid().'.'.$imageFile->guessExtension();

                // Move the file to the directory where they are stored
                try {
                    $imageFile->move(
                        $this->getParameter('images_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $post->setFoto($newFilename);
            }/* else{
                $newFilename = 'default.jpg';
                $pokemon->setImage($newFilename);
            } */
            $post->setAutor($this->getUser());

            //$meses = ["01"=>"Enero","02"=>"Febrero","03"=>"Marzo","04"=>"Abril","05"=>"Mayo","06"=>"Junio","07"=>"Julio","08"=>"Agosto","09"=>"Septiembre","10"=>"Octubre","11"=>"Noviembre","12"=>"Dicembre"];
            //$mes = strftime('%m');
            //$fecha = strftime("%d de $meses[$mes] de %G - %H horas");
            $fecha = new \DateTime();
            $post->setTime($fecha);
            
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('main', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('post/new.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{post}", name="post_show", methods={"GET", "POST"})
     */
    public function show(Request $request, EntityManagerInterface $entityManager, Post $post): Response
    {        
        //Para comentario
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $comment->setPost($post);
            $comment->setUser($this->getUSer());
            $comment->setTime(new \DateTime());

            $entityManager->persist($comment);
            $entityManager->flush();

            return $this->redirectToRoute('post_show', ["post"=> $post->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('post/show.html.twig', [
            'post' => $post,
            'form' => $form,
            'usuario' => $this->getUser()
        ]);
    }

    /**
     * @Route("/edit/{id}", name="post_edit", methods={"GET", "POST"})
     */
    public function edit(Post $post, Request $request, EntityManagerInterface $entityManager, PostRepository $repo): Response
    {
        $form = $this->createForm(PostType::class, $post);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //coger la imagen que haya en la bd, guardarla en una variable y asignarsela aqui si el campo es null
            $previousImg = $repo->findImgById($post->getId())->getFoto();
            if($form->get('foto')->getData() == null){
                $post->setFoto($previousImg);
            }
            //dump($previousImg);
            //exit;

            $entityManager->flush();

            return $this->redirectToRoute('user_show', ["nombreUsuario"=> $this->getUser()->getNombreUsuario()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('post/edit.html.twig', [
            'post' => $post,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/delete/{id}", name="post_delete", methods={"POST"})
     */
    public function delete(Request $request, Post $post, PostRepository $repo, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$post->getId(), $request->request->get('_token'))) {
            $img = $repo->findImgById($post->getId())->getFoto();
            $fs = new Filesystem(); //Para borrar el archivo fisico 

            try{
                $fs->remove($this->getParameter('images_directory').'/'.$img);
            }catch(FileException $e){

            }

            $entityManager->remove($post);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_show', ["nombreUsuario"=> $this->getUser()->getNombreUsuario()], Response::HTTP_SEE_OTHER);
    }
}
