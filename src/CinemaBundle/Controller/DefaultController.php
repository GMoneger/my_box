<?php

namespace CinemaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/cinema")
     */
    public function indexAction()
    {
        return $this->render('CinemaBundle:Default:index.html.twig');
    }
}
