<?php

namespace SBCPlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use SBCPlatformBundle\Entity\Deplacement;
use SBCPlatformBundle\Form\DeplacementType;
use SBCPlatformBundle\Form\DeplacementCancelType;
use SBCPlatformBundle\Form\DeplacementarriveeType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @Security("has_role('ROLE_ADMIN')")
 */
class DeplacementController extends Controller
{

    public function indexAction($page)
    {
        if ($page < 1) {
            throw $this->createNotFoundException("La page " . $page . " n'existe pas.");
        }

        $listDeplacements = $this->getDoctrine()
            ->getManager()
            ->getRepository('SBCPlatformBundle:Deplacement')
            ->getDeplacements(false);

        $deplacementEnAttente = 0;
        foreach ($listDeplacements as $deplacement) {
            if ($deplacement->getArrivedDate() == null)
                $deplacementEnAttente++;

        }

//        $this->addFlash('notice', $deplacementEnAttente);

        return $this->render('SBCPlatformBundle:Deplacement:index.html.twig', array(
            'listDeplacements' => $listDeplacements,
            'page' => $page,
            'cancelled' => false,
            'deplacementEnAttente' => $deplacementEnAttente
        ));
    }

    public function indexCancelledAction($page)
    {
        if ($page < 1) {
            throw $this->createNotFoundException("La page " . $page . " n'existe pas.");
        }

        $listDeplacements = $this->getDoctrine()
            ->getManager()
            ->getRepository('SBCPlatformBundle:Deplacement')
            ->getDeplacements(true);

        $deplacementEnAttente = 0;
        foreach ($listDeplacements as $deplacement) {
            if ($deplacement->getArrivedDate() == null)
                $deplacementEnAttente++;

        }

//        $this->addFlash('notice', $deplacementEnAttente);

        return $this->render('SBCPlatformBundle:Deplacement:index.html.twig', array(
            'listDeplacements' => $listDeplacements,
            'page' => $page,
            'cancelled' => true,
            'deplacementEnAttente' => $deplacementEnAttente
        ));
    }

    public function viewAction($id)
    {

        if ($id === '') {
            throw $this->createNotFoundException("Vous avez passé des données eronnées.");
        }

        $deplacement = $this->getDoctrine()->getRepository('SBCPlatformBundle:Deplacement')->getDeplacement($id);

        if ($deplacement === null) {
            throw $this->createNotFoundException("Le déplacement d'id " . $deplacement->getId() . " n'existe pas.");
        }

        return $this->render('SBCPlatformBundle:Deplacement:view.html.twig', array(
            'deplacement' => $deplacement
        ));
    }


    public function cancelAction($id, Request $request)
    {

        if ($id === '') {
            throw $this->createNotFoundException("Vous avez passé des données eronnées.");
        }

        $deplacement = $this->getDoctrine()->getRepository('SBCPlatformBundle:Deplacement')->getDeplacement($id);

        if (null === $deplacement) {
            throw new NotFoundHttpException("Le déplacement d'id " . $deplacement->getId() . " n'existe pas.");
        }

        $form = $this->createForm(DeplacementCancelType::class, $deplacement);

        if ($form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $deplacement->setCancelled(true);
            $deplacement->setCancellable(false);

            if ($deplacement->getStatus() == "Arrivé") {

                $deplacementEnDepart = $em->getRepository('SBCPlatformBundle:Deplacement')->getDepalcementEnDepartParReference($deplacement->getReference());
                $deplacementEnDepart->setArriveddate(null);
                $deplacementEnDepart->setCancellable(true);

                $em->persist($deplacementEnDepart);

            }
            if ($deplacement->getStatus() == "En départ") {

                $deplacementPrecedent = $em->getRepository('SBCPlatformBundle:Deplacement')->getLastDeplacementOfMateriel($deplacement->getMateriel(), "Arrivé");

                if ($deplacementPrecedent != null) {
                    $deplacementPrecedent->setCancellable(true);
                    $em->persist($deplacementPrecedent);
                }

            }

            $em->persist($deplacement);
            $em->flush();

            return $this->redirect($this->generateUrl('deplacement_view', array('id' => $deplacement->getId())));
        }

        return $this->render('SBCPlatformBundle:Deplacement:cancel.html.twig', array(
            'form' => $form->createView(),
            'deplacement' => $deplacement
         
        ));
    }


    public function addAction(Request $request)
    {

        $deplacement = new Deplacement();

        $deplacement->setReference(
            $this->getDoctrine()
                ->getManager()
                ->getRepository('SBCPlatformBundle:Deplacement')
                ->generateReference()
        );
        $deplacement->setStatus('En départ');
        $form = $this->get('form.factory')->create(DeplacementType::class, $deplacement);


        if ($form->handleRequest($request)->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $deplacementPrecedent = $em->getRepository('SBCPlatformBundle:Deplacement')
                ->getLastDeplacementOfMateriel($deplacement->getMateriel(), "Arrivé");

            if ($deplacementPrecedent != null) {

                $deplacementPrecedent->setCancellable(false);
                $em->persist($deplacementPrecedent);
            }


            $em->persist($deplacement);
            $em->flush();
            return $this->redirect($this->generateUrl('deplacement_view', array('id' => $deplacement->getId())));
        }


        return $this->render('SBCPlatformBundle:Deplacement:add.html.twig', array(
            'form' => $form->createView()
        ));
    }


    public
    function cloturerAction($id, Request $request)
    {

        if ($id === '') {
            throw $this->createNotFoundException("Vous avez passé des données eronnées.");
        }

        $deplacement = $this->getDoctrine()->getRepository('SBCPlatformBundle:Deplacement')->getDeplacement($id);


        if (null === $deplacement) {
            throw new NotFoundHttpException("Le déplacement d'id " . $deplacement->getId() . " n'existe pas.");
        }


        $deplacementToClose = new Deplacement();
        $deplacementToClose->setStatus("Arrivé");
        $deplacementToClose->setReference($deplacement->getReference());
        $deplacementToClose->setMateriel($deplacement->getMateriel());
        $deplacementToClose->setArriveddate($deplacement->getArriveddate());
        $deplacementToClose->setCreationdate($deplacement->getCreationdate());
        $deplacementToClose->setDeliverer($deplacement->getDeliverer());
        $deplacementToClose->setDeparturedate($deplacement->getDeparturedate());
        $deplacementToClose->setTransmitter($deplacement->getTransmitter());
        $deplacementToClose->setCurrentlocation($deplacement->getCurrentlocation());
        $deplacementToClose->setDestinatedlocation($deplacement->getDestinatedlocation());

        $form = $this->createForm(DeplacementarriveeType::class, $deplacementToClose);

        if ($form->handleRequest($request)->isValid()) {


            if ($deplacementToClose->getStatus() == 'Arrivé') {
                if (!$deplacementToClose->validateDates()) {
                    $this->addFlash('notice', 'here');
                    $form2 = $this->get('form.factory')->create(DeplacementarriveeType::class, $deplacement
                        //$deplacementToClose

                    );
                    return $this->render('SBCPlatformBundle:Deplacement:edit.html.twig', array(
                        'form' => $form2->createView()
                    ));
                }

            }

            $em = $this->getDoctrine()->getManager();
            $deplacement->setArriveddate($deplacementToClose->getArriveddate());
            $deplacement->setCancellable(false);

            $em->persist($deplacement);
            $em->persist($deplacementToClose);
            $em->flush();

            return $this->redirect($this->generateUrl('deplacement_view', array('id' => $deplacementToClose->getId())));
        }

        return $this->render('SBCPlatformBundle:Deplacement:edit.html.twig', array(
            'form' => $form->createView(),
            'deplacement' => $deplacementToClose

        ));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public
    function getLastDestinatedLocationOfMaterielAction(Request $request)
    {
        $q = $request->query->get('q'); //---get the q of search (GET)

        $searchRes = $this->getDoctrine()->getManager()->getRepository('SBCPlatformBundle:Deplacement')
            ->getLastDeplacementOfMateriel($q, "Arrivé");

        $res = null;
        if ($searchRes != null) {

            $res = array(
                'id' => $searchRes->getDestinatedlocation()->getId(),
                'text' => $searchRes->getDestinatedlocation()->getName(),
                'remainniglifetime' => $searchRes->getMateriel()->getLifetimeremaining(),

            );
        }


        return new JsonResponse($res);
    }

}