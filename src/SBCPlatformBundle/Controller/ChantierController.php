<?php

namespace SBCPlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use SBCPlatformBundle\Entity\Chantier;
use SBCPlatformBundle\Form\ChantierType;
use SBCPlatformBundle\Form\ChantierEditType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @Security("has_role('ROLE_ADMIN')")
 */
class ChantierController extends Controller
{

    public function indexAction($page)
    {
        if ($page < 1) {
            throw $this->createNotFoundException("La page " . $page . " n'existe pas.");
        }

        $listChantiers = $this->getDoctrine()
            ->getManager()
            ->getRepository('SBCPlatformBundle:Chantier')
            ->getChantiers();

        return $this->render('SBCPlatformBundle:Chantier:index.html.twig', array(
            'listChantiers' => $listChantiers,
            'page' => $page
        ));
    }

    public function viewAction(Chantier $chantier)
    {

        if ($chantier === null) {
            throw $this->createNotFoundException("Le chantier d'id " . $chantier->getId() . " n'existe pas.");
        }

        return $this->render('SBCPlatformBundle:Chantier:view.html.twig', array(
            'chantier' => $chantier
        ));
    }

    public function addAction(Request $request)
    {

        $chantier = new Chantier();
        $form = $this->get('form.factory')->create(ChantierType::class, $chantier);

        if ($form->handleRequest($request)->isValid()) {

            if ($chantier->getStatus() == 'Cloturé') {
                if (!$chantier->validateDates()) {
                    $this->addFlash('notice', 'here');
                    $form2 = $this->get('form.factory')->create(new ChantierType(), $chantier);
                    return $this->render('SBCPlatformBundle:Chantier:add.html.twig', array(
                        'form' => $form2->createView()
                    ));
                }

            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($chantier);
            $em->flush();

            return $this->redirect($this->generateUrl('chantier_view', array('id' => $chantier->getId())));
        }

        return $this->render('SBCPlatformBundle:Chantier:add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function editAction(Chantier $chantier, Request $request)
    {
        $em = $this->getDoctrine()->getManager();


        if (null === $chantier) {
            throw new NotFoundHttpException("Le chantier d'id " . $chantier->getId() . " n'existe pas.");
        }

        $form = $this->createForm(ChantierEditType::class, $chantier);

        if ($form->handleRequest($request)->isValid()) {

            if ($chantier->getStatus() == 'Cloturé') {
                if (!$chantier->validateDates()) {
                    $this->addFlash('notice', 'here');
                    $form2 = $this->get('form.factory')->create(ChantierType::class, $chantier);
                    return $this->render('SBCPlatformBundle:Chantier:edit.html.twig', array(
                        'form' => $form2->createView()
                    ));
                }

            }

            $em->flush();
            return $this->redirect($this->generateUrl('chantier_view', array('id' => $chantier->getId())));
        }

        return $this->render('SBCPlatformBundle:Chantier:edit.html.twig', array(
            'form' => $form->createView(),
            'chantier' => $chantier
        ));
    }

    public function deleteAction(Chantier $chantier)
    {
        $em = $this->getDoctrine()->getManager();
        $success = true;

        $msg = '';
        try {
            $em->remove($chantier);
            $em->flush();
        } catch (Exception $e) {
            $success = false;
            $msg = $e->getMessage();
        }

        return new JsonResponse(array('success' => $success, 'mesgerror' => $msg));


    }

    public function setstatusfinishedAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $chantier = $em->getRepository('SBCPlatformBundle:Chantier')->find($id);

        $chantier->setStatus("Cloturé");
        $chantier->setFinishDate(new \Datetime());

        $em->persist($chantier);
        $em->flush();

        return $this->redirect($this->generateUrl('chantier_home'));
    }

    public function setstatusstartedAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $chantier = $em->getRepository('SBCPlatformBundle:Chantier')->find($id);

        $chantier->setStatus("En cours");
        $chantier->setBeginDate(new \Datetime());

        $em->persist($chantier);
        $em->flush();

        return $this->redirect($this->generateUrl('chantier_home'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function ajaxAction(Request $request)
    {
        $reg = $request->query->get('q'); //---get the reg of search (GET)
        $searchRes = $this->getDoctrine()->getManager()->getRepository('SBCPlatformBundle:Chantier')->findByReg($reg);

        $res = array();
        foreach ($searchRes as $chantier) {
            $res[] = array(
                'id' => $chantier->getId(),
                'text' => $chantier->getName()." ".$chantier->getCode(),
            );
        }

        return new JsonResponse($res);
    }


}
