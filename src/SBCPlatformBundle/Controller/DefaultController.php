<?php

namespace SBCPlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

/**
 * @Security("has_role('ROLE_ADMIN')")
 */
class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SBCPlatformBundle:Default:index.html.twig');
    }
}
