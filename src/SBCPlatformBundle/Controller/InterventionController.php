<?php

namespace SBCPlatformBundle\Controller;

use SBCPlatformBundle\Entity\Intervention;
use SBCPlatformBundle\Form\InterventionType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @Security("has_role('ROLE_ADMIN')")
 */
class InterventionController extends Controller
{

    public function indexAction($page)
    {
        if ($page < 1) {
            throw $this->createNotFoundException("La page " . $page . " n'existe pas.");
        }

        $listInterventions = $this->getDoctrine()
            ->getManager()
            ->getRepository('SBCPlatformBundle:Intervention')
            ->getInterventions();

        return $this->render('SBCPlatformBundle:Intervention:index.html.twig', array(
            'listInterventions' => $listInterventions,
            'page' => $page
        ));
    }

    public function viewAction($id)
    {

        if ($id === null) {
            throw $this->createNotFoundException("Vous avez passé des données eronnées.");
        }

        $intervention = $this->getDoctrine()->getRepository('SBCPlatformBundle:Intervention')->getIntervention($id);

        if ($intervention === null) {
            throw $this->createNotFoundException("L'intervention d'id " . $id . " n'existe pas.");
        }

        return $this->render('SBCPlatformBundle:Intervention:view.html.twig', array(
            'intervention' => $intervention
        ));
    }

    public function addAction(Request $request)
    {

        $intervention = new Intervention();
        $form = $this->get('form.factory')->create(InterventionType::class, $intervention);

        if ($form->handleRequest($request)->isValid()) {
            $intervention->getTypeintervention()->setSumuseddurationsofpointages(0);

            $em = $this->getDoctrine()->getManager();
            $em->persist($intervention);
            $em->flush();

            return $this->redirect($this->generateUrl('intervention_view', array('id' => $intervention->getId())));
        }

        return $this->render('SBCPlatformBundle:Intervention:add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function editAction($id, Request $request)
    {

        if ('' === $id) {
            throw new NotFoundHttpException("Vous avez passé des données eronnées");
        }

        $intervention = $this->getDoctrine()->getRepository('SBCPlatformBundle:Intervention')->getIntervention($id);

        if ($intervention === null) {
            throw $this->createNotFoundException("L'intervention d'id " . $id . " n'existe pas.");
        }

        $form = $this->createForm(InterventionType::class, $intervention);

        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirect($this->generateUrl('intervention_view', array('id' => $intervention->getId())));
        }

        return $this->render('SBCPlatformBundle:Intervention:edit.html.twig', array(
            'form' => $form->createView(),
            'intervention' => $intervention
        ));
    }

    public function deleteAction(Intervention $intervention)
    {
        $em = $this->getDoctrine()->getManager();
        $success = true;

        $msg = '';
        try {
            $em->remove($intervention);
            $em->flush();
        } catch (\Exception $e) {
            $success = false;
            $msg = $e->getMessage();
        }

        return new JsonResponse(array('success' => $success, 'mesgerror' => $msg));

    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function ajaxAction(Request $request)
    {
        $reg = $request->query->get('q'); //---get the reg of search (GET)
        $searchRes = $this->getDoctrine()->getManager()->getRepository('SBCPlatformBundle:Intervention')->findByReg($reg);

        $res = array();
        foreach ($searchRes as $intervention) {
            $res[] = array(
                'id' => $intervention->getId(),
                'text' => $intervention->getName(),
            );
        }

        return new JsonResponse($res);
    }
}
