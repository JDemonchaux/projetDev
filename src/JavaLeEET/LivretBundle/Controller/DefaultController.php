<?php

namespace JavaLeEET\LivretBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('LivretBundle:Default:index.html.twig');
    }

    public function remplirAction() {
        return $this->render('LivretBundle:Default:index.html.twig');
    }

    public function consulterAction() {
        return $this->render('LivretBundle:Default:index.html.twig');
    }

    public function quinzaineAction() {
        return $this->render('LivretBundle:Default:quinzaine.html.twig');
    }

}
