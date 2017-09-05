<?php

namespace SBCPlatformBundle\Controller;

use SBCPlatformBundle\Entity\Notification;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use SBCPlatformBundle\Entity\Pointage;
use SBCPlatformBundle\Form\PointageType;
use SBCPlatformBundle\Form\PointageEditType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @Security("has_role('ROLE_ADMIN')")
 */
class PointageController extends Controller
{

    public function indexAction($page)
    {
        if ($page < 1) {
            throw $this->createNotFoundException("La page " . $page . " n'existe pas.");
        }

        $listPointages = $this->getDoctrine()
            ->getManager()
            ->getRepository('SBCPlatformBundle:Pointage')
            ->getPointages();

        return $this->render('SBCPlatformBundle:Pointage:index.html.twig', array(
            'listPointages' => $listPointages,
            'page' => $page
        ));
    }

    public function viewAction($id)
    {

        if ($id === '') {
            throw $this->createNotFoundException("Vous avez passé des données eronnées.");
        }

        $pointage = $this->getDoctrine()->getRepository('SBCPlatformBundle:Pointage')->getPointage($id);

        if (null === $pointage) {
            throw new NotFoundHttpException("Le pointage d'id " . $pointage->getId() . " n'existe pas.");
        }

        return $this->render('SBCPlatformBundle:Pointage:view.html.twig', array(
            'pointage' => $pointage
        ));
    }

    public function addAction(Request $request)
    {

        $pointage = new Pointage();
        $form = $this->get('form.factory')->create(PointageType::class, $pointage);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $pointage->getMateriel()->setLifetimeconsumed(
                $pointage->getMateriel()->getLifetimeconsumed() + $pointage->getUsedduration()
            );

            if ($pointage->getMateriel()->getLifetimeconsumed() > $pointage->getMateriel()->getLifetime()) {
                $this->addFlash('notice', $pointage->getMateriel()->getLifetimeremaining());
                $form2 = $this->get('form.factory')->create(PointageType::class, $pointage);
                return $this->render('SBCPlatformBundle:Pointage:add.html.twig', array(
                    'form' => $form2->createView()
                ));
            }

            $em = $this->getDoctrine()->getManager();

            // selectionner les types d'intervetion du matériel
            // et augmanter la valeur de $sumuseddurationsofpointages
            // par la durée utilisé lors du pointage

            $listTypesInterventionMateriel = $em
                ->getRepository('SBCPlatformBundle:PlanificationPrevention')
                ->findByMateriel($pointage->getMateriel());

            foreach ($listTypesInterventionMateriel as $typeIntervention){
                $typeIntervention->setSumuseddurationsofpointages(
                    $typeIntervention->getSumuseddurationsofpointages()
                    +$pointage->getUsedduration()
                );
                
                // ajouter notification si seuil sumuseddurationsofpointages

                if( $typeIntervention->getSumuseddurationsofpointages() >= $typeIntervention->getCyclevalue() ){
                    //Danger
                    $notification = new Notification();
                    $notification->setClass('md-list-addon-icon material-icons uk-text-danger');
                    $notification->setContent('L\'utilisation du matériel vient de dépasser le seuil du '. $typeIntervention->getNatureintervention()->getName().'.');
                    $notification->setIcon('&#xE001;');
//                    $notification->setLink('materiel/'.$typeIntervention->getMateriel()->getId());
                    $notification->setLink( array('id' => $typeIntervention->getMateriel()->getId()));
                    $notification->setTitle($typeIntervention->getMateriel()->getName());
                    $em->persist($notification);

                }
                elseif ($typeIntervention->getCyclevalue() - $typeIntervention->getThreshold() < $typeIntervention->getSumuseddurationsofpointages()){
                    //Warning
                    $notification = new Notification();
                    $notification->setClass('md-list-addon-icon material-icons uk-text-warning');
                    $notification->setContent('L\'utilisation du matériel est proche du seuil du '.$typeIntervention->getNatureintervention()->getName().'. Risque de lui dépasser');
                    $notification->setIcon('&#xE001;');
                    $notification->setLink('materiel/'.$typeIntervention->getMateriel()->getId());
                    $notification->setTitle($typeIntervention->getMateriel()->getName());
                    $em->persist($notification);
                }
                $em->persist($typeIntervention);
            }

            $em->persist($pointage);
            $em->flush();

            return $this->redirect($this->generateUrl('pointage_view', array('id' => $pointage->getId())));
        }

        return $this->render('SBCPlatformBundle:Pointage:add.html.twig', array(
            'form' => $form->createView()
        ));
    }

    public function editAction(Pointage $pointage, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        if (null === $pointage) {
            throw new NotFoundHttpException("Le Pointage d'id " . $pointage->getId() . " n'existe pas.");
        }

        $form = $this->createForm(PointageEditType::class, $pointage);

        if ($form->handleRequest($request)->isValid()) {

            $pointage->getMateriel()->setLifetimeconsumed(
                $pointage->getMateriel()->getLifetimeconsumed() + $pointage->getUsedduration()
            );

            if ($pointage->getMateriel()->getLifetimeconsumed() > $pointage->getMateriel()->getLifetime()) {
                $this->addFlash('notice', $pointage->getMateriel()->getLifetimeremaining());
                $form2 = $this->get('form.factory')->create(PointageType::class, $pointage);
                return $this->render('SBCPlatformBundle:Pointage:edit.html.twig', array(
                    'form' => $form2->createView()
                ));
            }

            $em->flush();
            return $this->redirect($this->generateUrl('pointage_view', array('id' => $pointage->getId())));
        }

        return $this->render('SBCPlatformBundle:Pointage:edit.html.twig', array(
            'form' => $form->createView(),
            'pointage' => $pointage
        ));
    }

}
