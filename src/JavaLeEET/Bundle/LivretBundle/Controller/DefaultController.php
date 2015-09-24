<?php

namespace JavaLeEET\Bundle\LivretBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('LivretBundle:Default:index.html.twig', array('name' => $name));
    }
}
