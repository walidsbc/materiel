<?php

namespace SBCPlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use SBCPlatformBundle\Entity\Materiel;
use SBCPlatformBundle\Form\MaterielType;
use SBCPlatformBundle\Form\MaterielEditType;
use SBCPlatformBundle\Form\MaterielDesactiverType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Security("has_role('ROLE_ADMIN')")
 */
class MaterielController extends Controller
{

    public function indexAction($page)
    {
        if ($page < 1) {
            throw $this->createNotFoundException("La page " . $page . " n'existe pas.");
        }
        $listMateriels = $this->getDoctrine()
            ->getManager()
            ->getRepository('SBCPlatformBundle:Materiel')
            ->getMateriels();

        return $this->render('SBCPlatformBundle:Materiel:index.html.twig', array(
            'listMateriels' => $listMateriels,
            'page' => $page
        ));
    }

    public function viewAction(Materiel $materiel)
    {
        return $this->render('SBCPlatformBundle:Materiel:view.html.twig', array(
            'materiel' => $materiel

        ));
    }

    public function addAction(Request $request)
    {

        $materiel = new Materiel();

        $form = $this->createForm(MaterielType::class, $materiel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($materiel);
            $em->flush();
            return $this->redirect($this->generateUrl('materiel_view', array('id' => $materiel->getId())));
        }

        return $this->render('SBCPlatformBundle:Materiel:add.html.twig', array(
            'form' => $form->createView(),
            'materiel' => $materiel
        ));
    }

    public function editAction(Materiel $materiel, Request $request)
    {

        $form = $this->createForm(MaterielEditType::class, $materiel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();

            foreach ($materiel->getFiles() as $file) {
                if ($file->getDescription() == null){
                    $materiel->removeFile($file);
                    $em->remove($file);
                }else{
                    $materiel->addFile($file);
                }
            }
            foreach ($materiel->getPlanifications() as $planification) {
                if ($planification->getThreshold() == null) {
                    $materiel->removePlanification($planification);
                    $em->remove($planification);
                } else {
                    $materiel->addPlanification($planification);
                }
            }

            $em->persist($materiel);
            $em->flush();
            return $this->redirect($this->generateUrl('materiel_view', array('id' => $materiel->getId())));
        }

        return $this->render('SBCPlatformBundle:Materiel:edit.html.twig', array(
            'form' => $form->createView(),
            'materiel' => $materiel

        ));
    }


    public function desactiverAction(Materiel $materiel, Request $request)
    {
        $form = $this->createForm(MaterielDesactiverType::class, $materiel);

        if ($form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $materielToDesactivate = $em->getRepository('SBCPlatformBundle:Materiel')->getMateriel($materiel->getId());
            $materielToDesactivate->setActivated(false);
            $materielToDesactivate->setStatus($materiel->getStatus());

            $em->remove($materiel);
            $em->persist($materielToDesactivate);

            $em->flush();
            return $this->redirect($this->generateUrl('materiel_view', array('id' => $materielToDesactivate->getId())));
        }

        return $this->render('SBCPlatformBundle:Materiel:desactiver.html.twig', array(
            'form' => $form->createView()

        ));
    }


    public function deleteAction(Materiel $materiel)
    {
        $em = $this->getDoctrine()->getManager();
        $success = true;
        $msg = '';

        try {
            $em->remove($materiel);
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
    public function ajaxWithJoinDeplacementAction(Request $request)
    {
        $reg = $request->query->get('q'); //---get the reg of search (GET)
        $searchRes = $this->getDoctrine()->getManager()->getRepository('SBCPlatformBundle:Materiel')->findByRegWithJoinDeplacement($reg);

        $res = array();
        foreach ($searchRes as $materiel) {
            $res[] = array(
                'id' => $materiel->getId(),
                'text' => $materiel->getName(),
                'remainniglifetime' => $materiel->getLifetimeremaining(),
            );
        }
        return new JsonResponse($res);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function allWithDeplcementsAction(Request $request)
    {
        $reg = $request->query->get('q'); //---get the reg of search (GET)
        $searchRes = $this->getDoctrine()->getManager()->getRepository('SBCPlatformBundle:Materiel')->allWithDeplcements($reg);
        $res = json_encode($searchRes);
        $res = str_replace('name', 'text', $res);
//        $res = str_replace('children', 'deplacements', $res);
        return new JsonResponse(json_decode($res));
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function ajaxFindByRegNotExistInDeplacementAction(Request $request)
    {
        $reg = $request->query->get('q'); //---get the reg of search (GET)
        $searchRes = $this->getDoctrine()->getManager()->getRepository('SBCPlatformBundle:Materiel')->findByRegNotExistInDeplacement($reg);

        $res = array();
        foreach ($searchRes as $materiel) {
            $res[] = array(
                'id' => $materiel->getId(),
                'text' => $materiel->getName(),
                'remainniglifetime' => $materiel->getLifetimeremaining(),
            );
        }

        return new JsonResponse($res);
    }


    public function getMaterielByNameAction($name)
    {
        $materiel = $this->getDoctrine()
            ->getManager()
            ->getRepository('SBCPlatformBundle:Materiel')
            ->findOneBy(array('name' => $name));

        $success = true;

        if ($materiel === null)
            $success = false;

        return new JsonResponse(array('success' => $success));

    }

    public function getMaterielByReferenceAction($reference)
    {
        $materiel = $this->getDoctrine()
            ->getManager()
            ->getRepository('SBCPlatformBundle:Materiel')
            ->findOneBy(array('reference' => $reference));

        $success = true;

        if ($materiel === null)
            $success = false;

        return new JsonResponse(array('success' => $success));

    }

    public function getMaterielByRegistrationAction($registration)
    {
        $materiel = $this->getDoctrine()
            ->getManager()
            ->getRepository('SBCPlatformBundle:Materiel')
            ->findOneBy(array('registration' => $registration));

        $success = true;

        if ($materiel === null)
            $success = false;

        return new JsonResponse(array('success' => $success));

    }

    public function getMaterielBySerialnumberAction($serialnumber)
    {
        $materiel = $this->getDoctrine()
            ->getManager()
            ->getRepository('SBCPlatformBundle:Materiel')
            ->findOneBy(array('serialnumber' => $serialnumber));

        $success = true;

        if ($materiel === null)
            $success = false;

        return new JsonResponse(array('success' => $success));

    }

}
