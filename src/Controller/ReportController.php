<?php

namespace App\Controller;

use App\Entity\Report;
use App\Entity\Post;
use App\Form\ReportType;
use App\Repository\ReportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/report")
 */
class ReportController extends AbstractController
{
    /**
     * @Route("/", name="report_index", methods={"GET"})
     */
    
    public function index(ReportRepository $reportRepository): Response
    {
        if($this->isGranted("ROLE_ADMIN"))
            return $this->render('report/index.html.twig', [
                'reports' => $reportRepository->findAll(),
            ]);
        else
            return $this->redirectToRoute('main');
    }

    /**
     * @Route("/new/{post}", name="report_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, Post $post): Response
    {
        $report = new Report();
        $form = $this->createForm(ReportType::class, $report);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $report->setIdUser($this->getUser());
            $report->setIdPost($post);
            $report->setRevisado(false);
            
            $entityManager->persist($report);
            $entityManager->flush();

            return $this->redirectToRoute('post_show', ["post"=> $post->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('report/new.html.twig', [
            'report' => $report,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/check/{id}", name="report_check", methods={"GET", "POST"})
     */
    public function check(Request $request, EntityManagerInterface $entityManager, Report $report): Response
    {
        $report->setRevisado(true);
        $entityManager->flush();

        return $this->redirectToRoute('report_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/{id}", name="report_show", methods={"GET"})
     
    public function show(Report $report): Response
    {
        return $this->render('report/show.html.twig', [
            'report' => $report,
        ]);
    }
    */
    /**
     * @Route("/{id}/edit", name="report_edit", methods={"GET", "POST"})
     
    public function edit(Request $request, Report $report, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReportType::class, $report);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('report_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('report/edit.html.twig', [
            'report' => $report,
            'form' => $form,
        ]);
    }
    */
    /**
     * @Route("/{id}", name="report_delete", methods={"POST"})
     
    public function delete(Request $request, Report $report, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$report->getId(), $request->request->get('_token'))) {
            $entityManager->remove($report);
            $entityManager->flush();
        }

        return $this->redirectToRoute('report_index', [], Response::HTTP_SEE_OTHER);
    }
    */
}
