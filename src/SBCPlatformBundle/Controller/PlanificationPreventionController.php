<?php

namespace SBCPlatformBundle\Controller;

use SBCPlatformBundle\Entity\PlanificationPrevention;
use SBCPlatformBundle\Form\PlanificationPreventionType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @Security("has_role('ROLE_ADMIN')")
 */
class PlanificationPreventionController extends Controller
{

    public function indexAction($page)
    {
        if ($page < 1) {
            throw $this->createNotFoundException("La page " . $page . " n'existe pas.");
        }

        $listPlanifications = $this->getDoctrine()
            ->getManager()
            ->getRepository('SBCPlatformBundle:PlanificationPrevention')
            ->findAll();

        return $this->render('SBCPlatformBundle:PlanificationPrevention:index.html.twig', array(
            'listPlanifications' => $listPlanifications,
            'page' => $page
        ));
    }

    public function viewAction($id)
    {

        if ($id === null) {
            throw $this->createNotFoundException("Vous avez passé des données eronnées.");
        }

        $planification = $this->getDoctrine()->getRepository('SBCPlatformBundle:PlanificationPrevention')->find($id);

        if ($planification === null) {
            throw $this->createNotFoundException("L'intervention d'id " . $id . " n'existe pas.");
        }

        return $this->render('SBCPlatformBundle:PlanificationPrevention:view.html.twig', array(
            'planification' => $planification
        ));
    }

    public function addAction(Request $request)
    {

        $planification = new PlanificationPrevention();
        $form = $this->get('form.factory')->create(PlanificationPreventionType::class, $planification);

        if ($form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($planification);
            $em->flush();

            return $this->redirect($this->generateUrl('planification_prevention_view', array('id' => $planification->getId())));
        }

        return $this->render('SBCPlatformBundle:PlanificationPrevention:add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function editAction($id, Request $request)
    {

        if ('' === $id) {
            throw new NotFoundHttpException("Vous avez passé des données eronnées");
        }

        $planification = $this->getDoctrine()->getRepository('SBCPlatformBundle:PlanificationPrevention')->find($id);

        if ($planification === null) {
            throw $this->createNotFoundException("La planification d'id " . $id . " n'existe pas.");
        }

        $form = $this->createForm(PlanificationPreventionType::class, $planification);

        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirect($this->generateUrl('planification_prevention_view', array('id' => $planification->getId())));
        }

        return $this->render('SBCPlatformBundle:PlanificationPrevention:edit.html.twig', array(
            'form' => $form->createView(),
            'planification' => $planification
        ));
    }

    public function deleteAction(PlanificationPrevention $planification)
    {
        $em = $this->getDoctrine()->getManager();
        $success = true;

        $msg = '';
        try {
            $em->remove($planification);
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
        $searchRes = $this->getDoctrine()->getManager()->getRepository('SBCPlatformBundle:PlanificationPrevention')->findByReg($reg);

        $res = array();
        foreach ($searchRes as $planification) {
            $res[] = array(
                'id' => $planification->getId(),
                'text' => $planification->getName(),
            );
        }

        return new JsonResponse($res);
    }
}
