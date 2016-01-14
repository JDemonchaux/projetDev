<?php

namespace JavaLeEET\LivretBundle\Controller;

use Doctrine\ODM\MongoDB\Mapping\Annotations\ObjectId;
use Doctrine\ODM\MongoDB\Types\ObjectIdType;
use JavaLeEET\LivretBundle\Document\Categorie;
use JavaLeEET\LivretBundle\Document\Livret;
use JavaLeEET\LivretBundle\Document\PeriodeFormation;
use JavaLeEET\LivretBundle\Document\Section;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Validator\Constraints\DateTime;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('LivretBundle:Default:index.html.twig');
    }

    public function quinzaineAction()
    {
        $odm = $this->get('doctrine_mongodb')->getManager();
        $id = $this->getUser()->getId();

        $livret = $odm->getRepository("LivretBundle:Livret")->findOneBy(array("apprenti" => new \MongoId($id)));

        return $this->render('LivretBundle:Default:quinzaine.html.twig', array("livret" => $livret));
    }

    public function quinzaineAjouterAction(Request $request)
    {
        if ($request->getMethod() == "POST") {
            $ddf = \DateTime::createFromFormat('d/m/y', $request->request->get("ddf"));
            $dff = \DateTime::createFromFormat('d/m/y', $request->request->get("dff"));
            $dde = \DateTime::createFromFormat('d/m/y', $request->request->get("dde"));
            $dfe = \DateTime::createFromFormat('d/m/y', $request->request->get("dfe"));
            $p = new PeriodeFormation();
            $p->setDateDebutE($dde);
            $p->setDateDebutF($ddf);
            $p->setDateFinE($dfe);
            $p->setDateFinF($dff);

            $odm = $this->get('doctrine_mongodb')->getManager();
            $id = $this->getUser()->getId();
            $livret = $odm->getRepository("LivretBundle:Livret")->findOneBy(array("apprenti" => new \MongoId($id)));

            $livret->setPeriodeFormation(array($p));

            $odm->persist($livret);
            $odm->flush();

            return $this->render('LivretBundle:Default:quinzaine.html.twig', array("livret" => $livret));
        } else {
            return $this->quinzaineAction();
        }
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

//        var_dump($livret->getActivite());
        return $this->render('LivretBundle:Default:consulterLivret.html.twig', array("livret" => $livret));
    }
    
    public function mentionsAction()
    {
        return $this->render('LivretBundle:Default:mentions.html.twig');
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
