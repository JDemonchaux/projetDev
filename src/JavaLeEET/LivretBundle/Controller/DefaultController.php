<?php

namespace JavaLeEET\LivretBundle\Controller;

use Doctrine\ODM\MongoDB\Mapping\Annotations\ObjectId;
use Doctrine\ODM\MongoDB\Types\ObjectIdType;
use JavaLeEET\LivretBundle\Document\Categorie;
use JavaLeEET\LivretBundle\Document\Livret;
use JavaLeEET\LivretBundle\Document\Section;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session\Session;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('LivretBundle:Default:index.html.twig');
    }

    public function remplirAction()
    {
        $odm = $this->get('doctrine_mongodb')->getManager();
        $livret = $odm->getRepository("LivretBundle:Livret")->findAll();

        return $this->render('LivretBundle:Default:index.html.twig', array("livret" => $livret));
    }

    public function consulterAction()
    {
        $odm = $this->get('doctrine_mongodb')->getManager();
        $id = $this->getUser()->getId();

        $livret = $odm->getRepository("LivretBundle:Livret")->findOneBy(array("apprenti" => new \MongoId($id)));

//        $qb = $odm->createQueryBuilder('LivretBundle:Livret');
//        $livret = $qb->field("apprenti")->equals("566ddac3071339a413000029")->getQuery()->getSingleResult();



        return $this->render('LivretBundle:Default:consulterLivret.html.twig', array("livret" => $livret));
    }

    public function remplirQuinzaineAction()
    {
        return $this->render('LivretBundle:Default:remplirQuinzaine.html.twig');
    }

    /**
     * Route qui génére le livret en bdd
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function genererAction()
    {
        $odm = $this->get('doctrine_mongodb')->getManager();

        $idApprenti = $this->getUser()->getId();
        $livret = new Livret();
        $livret->genererLivret($idApprenti);
        $odm->persist($livret);
        $odm->flush();

        return $this->indexAction();
    }
}
