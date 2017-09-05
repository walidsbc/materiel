<?php

namespace SBCPlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use SBCPlatformBundle\Entity\Ouvrier;
use SBCPlatformBundle\Form\OuvrierType;
use SBCPlatformBundle\Form\OuvrierEditType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @Security("has_role('ROLE_ADMIN')")
 */
class OuvrierController extends Controller
{

    public function indexAction($page)
    {
        if ($page < 1) {
            throw $this->createNotFoundException("La page " . $page . " n'existe pas.");
        }

        $listOuvriers = $this->getDoctrine()
            ->getManager()
            ->getRepository('SBCPlatformBundle:Ouvrier')
            ->getOuvriers();

        return $this->render('SBCPlatformBundle:Ouvrier:index.html.twig', array(
            'listOuvriers' => $listOuvriers,
            'page' => $page
        ));
    }

    public function viewAction(Ouvrier $ouvrier)
    {
        if ($ouvrier === null) {
            throw $this->createNotFoundException("L'Ouvrier d'id " . $ouvrier->getId() . " n'existe pas.");
        }

        return $this->render('SBCPlatformBundle:Ouvrier:view.html.twig', array(
            'ouvrier' => $ouvrier
        ));
    }

    public function addAction(Request $request)
    {

        $ouvrier = new Ouvrier();
        $ouvrier->setCode(
            $this->getDoctrine()
                ->getManager()
                ->getRepository('SBCPlatformBundle:Ouvrier')
                ->generateCode()
        );
        $form = $this->get('form.factory')->create(OuvrierType::class, $ouvrier);

        if ($form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($ouvrier);
            $em->flush();

            return $this->redirect($this->generateUrl('ouvrier_view', array('id' => $ouvrier->getId())));
        }

        return $this->render('SBCPlatformBundle:Ouvrier:add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function editAction(Ouvrier $ouvrier, Request $request)
    {
        $em = $this->getDoctrine()->getManager();


        if (null === $ouvrier) {
            throw new NotFoundHttpException("L'Ouvrier d'id " . $ouvrier->getId() . " n'existe pas.");
        }

        $form = $this->createForm(OuvrierEditType::class, $ouvrier);

        if ($form->handleRequest($request)->isValid()) {
            $em->flush();
            return $this->redirect($this->generateUrl('ouvrier_view', array('id' => $ouvrier->getId())));
        }

        return $this->render('SBCPlatformBundle:Ouvrier:edit.html.twig', array(
            'form' => $form->createView(),
            'ouvrier' => $ouvrier
        ));
    }

    public function deleteAction(Ouvrier $ouvrier)
    {
        $em = $this->getDoctrine()->getManager();
        $success = true;

        $msg = '';
        try {
            $em->remove($ouvrier);
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
        $searchRes = $this->getDoctrine()->getManager()->getRepository('SBCPlatformBundle:Ouvrier')->findByReg($reg);

        $res = array();
        foreach ($searchRes as $ouvrier) {
            $res[] = array(
                'id' => $ouvrier->getId(),
                'text' => $ouvrier->getName()." - ".$ouvrier->getCode(),
            );
        }

        return new JsonResponse($res);
    }

    public function getOuvrierByCodeAction($code)
    {
        $ouvrier = $this->getDoctrine()
            ->getManager()
            ->getRepository('SBCPlatformBundle:Ouvrier')
            ->findOneBy(array('code' => $code));

        $success = true;

        if ($ouvrier === null)
            $success = false;

        return new JsonResponse(array('success' => $success));

    }

    public function getOuvrierByCinAction($cin)
    {
        $ouvrier = $this->getDoctrine()
            ->getManager()
            ->getRepository('SBCPlatformBundle:Ouvrier')
            ->findOneBy(array('cin' => $cin));

        $success = true;

        if ($ouvrier === null)
            $success = false;

        return new JsonResponse(array('success' => $success));

    }

    public function getOuvrierByPhoneNumberAction($phonenumber)
    {
        $ouvrier = $this->getDoctrine()
            ->getManager()
            ->getRepository('SBCPlatformBundle:Ouvrier')
            ->findOneBy(array('phonenumber' => $phonenumber));

        $success = true;

        if ($ouvrier === null)
            $success = false;

        return new JsonResponse(array('success' => $success));

    }
}
