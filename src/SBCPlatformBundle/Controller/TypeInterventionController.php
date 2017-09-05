<?php

namespace SBCPlatformBundle\Controller;

use SBCPlatformBundle\Entity\TypeIntervention;
use SBCPlatformBundle\Form\TypeInterventionType2;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @Security("has_role('ROLE_ADMIN')")
 */
class TypeInterventionController extends Controller
{

    public function indexAction($page)
    {
        if ($page < 1) {
            throw $this->createNotFoundException("La page " . $page . " n'existe pas.");
        }

        $listTypesIntervention = $this->getDoctrine()
            ->getManager()
            ->getRepository('SBCPlatformBundle:TypeIntervention')
            ->getTypesIntervention();

        return $this->render('SBCPlatformBundle:TypeIntervention:index.html.twig', array(
            'listTypesIntervention' => $listTypesIntervention,
            'page' => $page
        ));
    }

    public function viewAction($id)
    {
        if ($id === null) {
            throw $this->createNotFoundException("Vous avez passé des données eronnées.");
        }

        $typeIntervention = $this->getDoctrine()->getRepository('SBCPlatformBundle:TypeIntervention')->getTypeIntervention($id);

        if ($typeIntervention === null) {
            throw $this->createNotFoundException("Le type d'intervention d'id " . $id . " n'existe pas.");
        }

        return $this->render('SBCPlatformBundle:TypeIntervention:view.html.twig', array(
            'typeIntervention' => $typeIntervention
        ));
    }

    public function addAction(Request $request)
    {

        $typeIntervention = new TypeIntervention();
        $form = $this->get('form.factory')->create(TypeInterventionType2::class, $typeIntervention);

        if ($form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($typeIntervention);
            $em->flush();

            return $this->redirect($this->generateUrl('typeintervention_view', array('id' => $typeIntervention->getId())));
        }

        return $this->render('SBCPlatformBundle:TypeIntervention:add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function editAction($id, Request $request)
    {

        if ('' === $id) {
            throw new NotFoundHttpException("Vous avez passé des données eronnées");
        }

        $typeIntervention = $this->getDoctrine()->getRepository('SBCPlatformBundle:TypeIntervention')->getTypeIntervention($id);

        if ($typeIntervention === null) {
            throw $this->createNotFoundException("Le type d'intervention d'id " . $id . " n'existe pas.");
        }

        $form = $this->createForm(TypeInterventionType2::class, $typeIntervention);

        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirect($this->generateUrl('typeintervention_view', array('id' => $typeIntervention->getId())));
        }

        return $this->render('SBCPlatformBundle:TypeIntervention:edit.html.twig', array(
            'form' => $form->createView(),
            'typeIntervention' => $typeIntervention
        ));
    }

    public function deleteAction(TypeIntervention $typeIntervention)
    {
        $em = $this->getDoctrine()->getManager();
        $success = true;

        $msg = '';
        try {
            $em->remove($typeIntervention);
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

        $res['results'] = array();
        $oldtext = '';
        $i = 0;

        //Set text elements(group elements)
        foreach ($searchRes as $typeIntervention) {
            if ($typeIntervention->getMateriel()->getName() != $oldtext) {
                $res['results'][$i]['text'] = $typeIntervention->getMateriel()->getName();
                $res['results'][$i]['children']= array();

                $oldtext = $typeIntervention->getMateriel()->getName();
                $i++;
            }
        }

//        Set results elements for each group
        foreach ($res['results'] as $key => $item) {
            $results = array();

            foreach ($searchRes as $typeIntervention) {
                if ($typeIntervention->getMateriel()->getName() == $res['results'][$key]['text']) {

                    $t = array();
                    $t['id'] = $typeIntervention->getId();
                    $t['text'] = $typeIntervention->getNatureIntervention()->getName();
                    $results[] = $t;

                }
            }
            $res['results'][$key]['children'] = $results;
        }

        return new JsonResponse($res);
    }
}
