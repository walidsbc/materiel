<?php

namespace SBCPlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Security("has_role('ROLE_ADMIN')")
 */
class CoutController extends Controller
{

    public function coutParEmplacementAction($page)
    {
        if ($page < 1) {
            throw $this->createNotFoundException("La page " . $page . " n'existe pas.");
        }

        $listCouts = $this->getDoctrine()
            ->getManager()
            ->getRepository('SBCPlatformBundle:Pointage')
            ->getPointagesParEmplacement();

        
        return $this->render('SBCPlatformBundle:Cout:coutParEmplacement.html.twig', array(
            'listCouts' => $listCouts,
            'page' => $page
        ));
    }


}
