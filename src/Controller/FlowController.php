<?php

namespace App\Controller;

use App\Entity\Flow;
use App\Form\FlowType;
use App\Repository\FlowRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FlowController extends Controller
{
    /**
     * @Route("/", name="flow_index", methods={"GET"})
     */
    public function index(FlowRepository $flowRepository): Response
    {
        return $this->render('flow/index.html.twig', [
            'flows' => $flowRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="flow_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $flow = new Flow();
        $form = $this->createForm(FlowType::class, $flow);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($flow);
            $entityManager->flush();

            return $this->redirectToRoute('flow_index');
        }

        return $this->render('flow/new.html.twig', [
            'flow' => $flow,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="flow_show", methods={"GET"})
     */
    public function show(Flow $flow): Response
    {
        if (!$flow->hasSteps()) {
            return $this->redirectToRoute('step_new_no_parent', ['flowId' => $flow->getId()]);
        }

        $step = $flow->getFirstStep();
        return $this->render('step/show.html.twig', [
            'step' => $step,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="flow_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Flow $flow): Response
    {
        $form = $this->createForm(FlowType::class, $flow);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('flow_index');
        }

        return $this->render('flow/edit.html.twig', [
            'flow' => $flow,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/map", name="flow_map", methods={"GET"})
     */
    public function map(Flow $flow): Response
    {

        return $this->render('flow/map.html.twig', [
            'flow' => $flow
        ]);
    }

    /**
     * @Route("/{id}", name="flow_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Flow $flow): Response
    {
        if ($this->isCsrfTokenValid('delete'.$flow->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($flow);
            $entityManager->flush();
        }

        return $this->redirectToRoute('flow_index');
    }
}
