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
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render('CinemaBundle:Default:index.html.twig');
    }

    /**
     * @Route("/room1")
     */
    public function room1Action()
    {
        return $this->render('CinemaBundle:Default/rooms:room1.html.twig');
    }

    /**
     * @Route("/room2")
     */
    public function room2Action()
    {
        return $this->render('CinemaBundle:Default/rooms:room2.html.twig');
    }

    /**
     * @Route("/room3")
     */
    public function room3Action()
    {
        return $this->render('CinemaBundle:Default/rooms:room3.html.twig');
    }
}
