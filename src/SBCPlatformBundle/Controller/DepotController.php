<?php

namespace SBCPlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use SBCPlatformBundle\Entity\Depot;
use SBCPlatformBundle\Form\DepotType;
use SBCPlatformBundle\Form\DepotEditType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @Security("has_role('ROLE_ADMIN')")
 */
class DepotController extends Controller
{

    public function indexAction($page)
    {
        if ($page < 1) {
            throw $this->createNotFoundException("La page " . $page . " n'existe pas.");
        }
        $listDepots = $this->getDoctrine()
            ->getManager()
            ->getRepository('SBCPlatformBundle:Depot')
            ->findAll();
        return $this->render('SBCPlatformBundle:Depot:index.html.twig', array(
            'listDepots' => $listDepots,
            'page' => $page
        ));
    }

    public function viewAction(Depot $depot)
    {
        if ($depot === null) {
            throw $this->createNotFoundException("Le dépôt d'id " . $depot->getId() . " n'existe pas.");
        }

        return $this->render('SBCPlatformBundle:Depot:view.html.twig', array(
            'depot' => $depot));
    }

    public function addAction(Request $request)
    {

        $depot = new Depot();
        $form = $this->get('form.factory')->create(DepotType::class, $depot);

        if ($form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($depot);
            $em->flush();

            return $this->redirect($this->generateUrl('depot_view', array('id' => $depot->getId())));
        }

        return $this->render('SBCPlatformBundle:Depot:add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function editAction(Depot $depot, Request $request)
    {
        $em = $this->getDoctrine()->getManager();


        if (null === $depot) {
            throw new NotFoundHttpException("Le dépôt d'id " . $depot->getId() . " n'existe pas.");
        }

        $form = $this->createForm(DepotEditType::class, $depot);

        if ($form->handleRequest($request)->isValid()) {
            $em->flush();
            return $this->redirect($this->generateUrl('depot_view', array('id' => $depot->getId())));
        }

        return $this->render('SBCPlatformBundle:Depot:edit.html.twig', array(
            'form' => $form->createView(),
            'depot' => $depot
        ));
    }

    public function deleteAction(Depot $depot)
    {
        $em = $this->getDoctrine()->getManager();
        $success = true;

        $msg = '';
        try {
            $em->remove($depot);
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
        $searchRes = $this->getDoctrine()->getManager()->getRepository('SBCPlatformBundle:Depot')->findByReg($reg);

        $res = array();
        foreach ($searchRes as $depot) {
            $res[] = array(
                'id' => $depot->getId(),
                'text' => $depot->getName()." ".$depot->getCode(),
            );
        }

        return new JsonResponse($res);
    }
}
