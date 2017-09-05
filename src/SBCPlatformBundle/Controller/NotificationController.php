<?php

namespace SBCPlatformBundle\Controller;

use SBCPlatformBundle\Entity\Notification;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Security("has_role('ROLE_ADMIN')")
 */
class NotificationController extends Controller
{

    public function indexAction($page)
    {
        if ($page < 1) {
            throw $this->createNotFoundException("La page " . $page . " n'existe pas.");
        }
        $listNotifications = $this->getDoctrine()
            ->getManager()
            ->getRepository('SBCPlatformBundle:Notification')
            ->getNotifications();

        return $this->render('SBCPlatformBundle:Notification:index.html.twig', array(
            'listNotifications' => $listNotifications,
            'page' => $page
        ));
    }

    public function someNotificationsAction()
    {
        $someNotifications = $this->getDoctrine()
            ->getManager()
            ->getRepository('SBCPlatformBundle:Notification')
            ->getSomeNotifications();

        return new JsonResponse($someNotifications);

    }


    public function addAction(Notification $notification)
    {
        $em = $this->getDoctrine()->getManager();

        try {
            $em->persist($notification);
            $em->flush();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function editAction()
    {
          $i=   $this->getDoctrine()
                ->getManager()
                ->getRepository('SBCPlatformBundle:Notification')
                ->setNotificationsSeen();
        return new Response("true");
    }
}
