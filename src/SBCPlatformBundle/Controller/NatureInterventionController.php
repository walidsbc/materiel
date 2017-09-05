<?php

namespace SBCPlatformBundle\Controller;

use SBCPlatformBundle\Entity\NatureIntervention;
use SBCPlatformBundle\Form\NatureInterventionType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @Security("has_role('ROLE_ADMIN')")
 */
class NatureInterventionController extends Controller
{

    public function indexAction($page)
    {
        if ($page < 1) {
            throw $this->createNotFoundException("La page " . $page . " n'existe pas.");
        }

        $listNaturesIntervention = $this->getDoctrine()
            ->getManager()
            ->getRepository('SBCPlatformBundle:NatureIntervention')
            ->findAll();

        return $this->render('SBCPlatformBundle:NatureIntervention:index.html.twig', array(
            'listNaturesIntervention' => $listNaturesIntervention,
            'page' => $page
        ));
    }

    public function viewAction(NatureIntervention $natureIntervention)
    {

        if ($natureIntervention === null) {
            throw $this->createNotFoundException("La nature d'intervention d'id " . $natureIntervention->getId() . " n'existe pas.");
        }

        return $this->render('SBCPlatformBundle:NatureIntervention:view.html.twig', array(
            'natureIntervention' => $natureIntervention));
    }

    public function addAction(Request $request)
    {

        $natureIntervention = new natureIntervention();
        $form = $this->get('form.factory')->create(NatureInterventionType::class, $natureIntervention);

        if ($form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($natureIntervention);
            $em->flush();

            return $this->redirect($this->generateUrl('natureintervention_view', array('id' => $natureIntervention->getId())));
        }

        return $this->render('SBCPlatformBundle:NatureIntervention:add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function editAction(NatureIntervention $natureIntervention, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        if (null === $natureIntervention) {
            throw new NotFoundHttpException("La nture d'intervention d'id " . $natureIntervention->getId() . " n'existe pas.");
        }

        $form = $this->createForm(NatureInterventionType::class, $natureIntervention);

        if ($form->handleRequest($request)->isValid()) {
            $em->flush();
            return $this->redirect($this->generateUrl('natureintervention_view', array('id' => $natureIntervention->getId())));
        }

        return $this->render('SBCPlatformBundle:NatureIntervention:edit.html.twig', array(
            'form' => $form->createView(),
            'natureIntervention' => $natureIntervention
        ));
    }

    public function deleteAction(NatureIntervention $natureIntervention, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $success = true;

        $msg = '';
        try {
            $em->remove($natureIntervention);
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
        $searchRes = $this->getDoctrine()->getManager()->getRepository('SBCPlatformBundle:NatureIntervention')->findByReg($reg);

        $res = array();
        foreach ($searchRes as $natureIntervention) {
            $res[] = array(
                'id' => $natureIntervention->getId(),
                'text' => $natureIntervention->getName(),
            );
        }

        return new JsonResponse($res);
    }

    public function getNatureInterventionByNameAction($name)
    {
        $natureintervention = $this->getDoctrine()
            ->getManager()
            ->getRepository('SBCPlatformBundle:NatureIntervention')
            ->findOneBy(array('name' => $name));

        $success = true;

        if ($natureintervention === null)
            $success = false;

        return new JsonResponse(array('success' => $success));

    }
}