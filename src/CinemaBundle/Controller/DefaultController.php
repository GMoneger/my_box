<?php

namespace CinemaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * @Route("/cinema")
 */
class DefaultController extends Controller
{
    /**
     * @Route("/", name="cinema")
     */
    public function indexAction()
    {
        return $this->render('CinemaBundle:Default:index.html.twig');
    }

    /**
     * @Route("/salle/{type_film}", name="room")
     */
    public function roomAction($type_film)
    {
        return $this->render('CinemaBundle:Default/rooms:room.html.twig', array('type_salle' => $type_film));
    }
}
