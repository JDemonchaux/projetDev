<?php

namespace JavaLeEET\LivretBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('LivretBundle:Default:index.html.twig');
    }
}
