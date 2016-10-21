<?php

namespace ChatBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/chat")
     */
    public function indexAction()
    {
        $user = $this->getUser();

        return $this->render('ChatBundle:Default:index.html.twig', array('user' => $user));
    }
}
