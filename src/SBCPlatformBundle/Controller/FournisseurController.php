<?php

namespace SBCPlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use SBCPlatformBundle\Entity\Fournisseur;
use SBCPlatformBundle\Form\FournisseurType;
use SBCPlatformBundle\Form\FournisseurEditType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @Security("has_role('ROLE_ADMIN')")
 */
class FournisseurController extends Controller
{

    public function getFournisseurByCompanyNameAction($companyname)
    {
        $fournisseur = $this->getDoctrine()
            ->getManager()
            ->getRepository('SBCPlatformBundle:Fournisseur')
            ->findOneBy(array('companyname' => $companyname));

        $success = true;

        if ($fournisseur === null)
            $success = false;

        return new JsonResponse(array('success' => $success));

    }

    public function indexAction($page)
    {
        if ($page < 1) {
            throw $this->createNotFoundException("La page " . $page . " n'existe pas.");
        }
        $listFournisseurs = $this->getDoctrine()
            ->getManager()
            ->getRepository('SBCPlatformBundle:Fournisseur')
            ->getFournisseurs();
        return $this->render('SBCPlatformBundle:Fournisseur:index.html.twig', array(
            'listFournisseurs' => $listFournisseurs,
            'page' => $page
        ));
    }

    public function viewAction(Fournisseur $fournisseur)
    {
        if ($fournisseur === null) {
            throw $this->createNotFoundException("Le fournisseur d'id " . $fournisseur->getId() . " n'existe pas.");
        }

        return $this->render('SBCPlatformBundle:Fournisseur:view.html.twig', array(
            'fournisseur' => $fournisseur
        ));
    }

    public function addAction(Request $request)
    {

        $fournisseur = new Fournisseur();
        $form = $this->get('form.factory')->create(FournisseurType::class, $fournisseur);

        if ($form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($fournisseur);
            $em->flush();

            return $this->redirect($this->generateUrl('fournisseur_view', array('id' => $fournisseur->getId())));
        }

        return $this->render('SBCPlatformBundle:Fournisseur:add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function editAction(Fournisseur $fournisseur, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        if (null === $fournisseur) {
            throw new NotFoundHttpException("Le fournisseur d'id " . $fournisseur->getId() . " n'existe pas.");
        }

        $form = $this->createForm(FournisseurEditType::class, $fournisseur);

        if ($form->handleRequest($request)->isValid()) {
            $em->flush();
            return $this->redirect($this->generateUrl('fournisseur_view', array('id' => $fournisseur->getId())));
        }

        return $this->render('SBCPlatformBundle:Fournisseur:edit.html.twig', array(
            'form' => $form->createView(),
            'fournisseur' => $fournisseur
        ));
    }

    public function deleteAction(Fournisseur $fournisseur)
    {
        $em = $this->getDoctrine()->getManager();
        $success = true;

        $msg = '';
        try {
            $em->remove($fournisseur);
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
        $searchRes = $this->getDoctrine()->getManager()->getRepository('SBCPlatformBundle:Fournisseur')->findByReg($reg);

        $res = array();
        foreach ($searchRes as $fournisseur) {
            $res[] = array(
                'id' => $fournisseur->getId(),
                'text' => $fournisseur->getCompanyname(),
            );
        }

        return new JsonResponse($res);
    }

}
