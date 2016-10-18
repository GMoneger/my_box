<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/app/chat", name="homepage")
     */
    public function indexAction()
    {
        return $this->render('AppBundle::index.html.twig');
    }
}
