<?php

namespace App\Controller;

use App\Entity\Link;
use App\Entity\Step;
use App\Entity\Flow;
use App\Form\LinkType;
use App\Repository\LinkRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LinkController extends Controller
{
    /**
     * @Route("/{flow}/{step}/link", name="link_new", methods={"GET","POST"})
     */
    public function new(Request $request, Flow $flow, Step $step): Response
    {
        $link = new Link();

        $link->setFlow($flow);
        $link->setParentStep($step);

        $form = $this->createForm(LinkType::class, $link);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($link);
            $entityManager->flush();

            return $this->redirectToRoute(
                'step_edit',
                [
                    'flow' => $flow->getId(),
                    'step' => $step->getId()
                ]
            );
        }

        return $this->render('link/new.html.twig', [
            'link' => $link,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{flow}/{step}/link/{id}/edit", name="link_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Flow $flow, Step $step, Link $link): Response
    {
        $form = $this->createForm(LinkType::class, $link);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute(
                'step_edit', 
                [
                    'flow' => $flow->getId(),
                    'step' => $step->getId()
                ]
            );
        }

        return $this->render('link/edit.html.twig', [
            'link' => $link,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{flow}/{step}/link/{id}/delete", name="link_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Link $link): Response
    {
        if ($this->isCsrfTokenValid('delete'.$link->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($link);
            $entityManager->flush();
        }

        return $this->redirectToRoute(
            'step_edit',
            [
                'flow' => $link->getFlow()->getId(),
                'step' => $link->getParentStep()->getId()
            ]
        );
    }
}
