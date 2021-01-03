<?php

namespace App\Controller;

use App\Entity\Step;
use App\Entity\Flow;
use App\Form\StepType;
use App\Form\EditStepType;
use App\Repository\StepRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StepController extends Controller
{

    /**
     * @Route("/{flowId}/add", name="step_new_no_parent", methods={"GET","POST"})
     * @Route("/{flowId}/{parentId}/add", name="step_new", methods={"GET","POST"})
     */
    public function new(Request $request, $flowId, $parentId=null): Response
    {
        $flow = $this->getDoctrine()->getRepository(Flow::class)->find($flowId);
        $step = new Step();
        $step->setFlow($flow);
        if ($parentId) {
            $parent = $this->getDoctrine()->getRepository(Step::class)->find($parentId);
            $step->setParent($parent);
        }
        $form = $this->createForm(StepType::class, $step);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($step);
            $entityManager->flush();

            return $this->redirectToRoute(
                'step_show', 
                [ 
                    'edit' => true,
                    'flow' => $flow->getId(), 
                    'step' => $step->getId()
                ]
            );
        }

        return $this->render('step/new.html.twig', [
            'step' => $step,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{flow}/{step}/edit", name="step_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Flow $flow, Step $step): Response
    {
        $form = $this->createForm(EditStepType::class, $step);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute(
                'step_show', 
                [ 
                    'flow' => $flow->getId(), 
                    'step' => $step->getId()
                ]
            );
        }

        return $this->render('step/edit.html.twig', [
            'edit' => true,
            'flow' => $flow,
            'step' => $step,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{flow}/{step}", name="step_show", methods={"GET"})
     */
    public function show(Flow $flow, Step $step): Response
    {
        return $this->render('step/show.html.twig', [
            'step' => $step,
        ]);
    }

    /**
     * @Route("/{flow}/{step}", name="step_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Flow $flow, Step $step): Response
    {
        if ($this->isCsrfTokenValid('delete'.$step->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($step);
            $entityManager->flush();
        }

        return $this->redirectToRoute('flow_show', [ 'id' => $flow->getId() ]);
    }
}
