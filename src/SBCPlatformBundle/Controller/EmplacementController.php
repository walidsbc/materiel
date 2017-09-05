<?php

namespace SBCPlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Security("has_role('ROLE_ADMIN')")
 */
class EmplacementController extends Controller{

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function ajaxAction(Request $request)
    {
        $reg = $request->query->get('q'); //---get the reg of search (GET)
        $searchRes = $this->getDoctrine()->getManager()->getRepository('SBCPlatformBundle:Emplacement')->findByReg($reg);

        $res = array();
        foreach ($searchRes as $emplacement) {
            $res[] = array(
                'id' => $emplacement->getId(),
                'text' => $emplacement->getName()." - ".$emplacement->getCode(),
            );
        }

        return new JsonResponse($res);
    }

}