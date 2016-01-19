<?php

namespace JavaLeEET\LivretBundle\Controller;

use Doctrine\ODM\MongoDB\Mapping\Annotations\ObjectId;
use Doctrine\ODM\MongoDB\Types\ObjectIdType;
use JavaLeEET\LivretBundle\Document\Categorie;
use JavaLeEET\LivretBundle\Document\Livret;
use JavaLeEET\LivretBundle\Document\PeriodeFormation;
use JavaLeEET\LivretBundle\Document\Section;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $odm = $this->get("doctrine_mongodb")->getManager();
        $user = $odm->getRepository("UtilisateurBundle:Utilisateur")->find($this->getUser()->getId());

        $signature = false;

        if (NULL !== $user->getSignature()) {
            $signature = true;
        }

        return $this->render('LivretBundle:Default:index.html.twig', array("signature" => $signature));
    }


    public function aideAction()
    {
        return $this->render('LivretBundle:Default:aide.html.twig');
    }


    public function choisirApprentiAction()
    {
        // Vue pour le RD
        // On affiche tous les apprentis
        $odm = $this->get("doctrine_mongodb")->getManager();

        $app = $odm->getRepository("UtilisateurBundle:Utilisateur")->findAll();
        //@TODO : filter les apprentis dans la requetes
        $apprentis = array();
        foreach ($app as $apprenti) {
            if ($apprenti->getRoles()[0] == "ROLE_APPRENTI") {
                $apprentis[] = $apprenti;
            }
        }


        return $this->render('LivretBundle:Default:choixApprentis.html.twig', array("apprentis" => $apprentis));
    }

    public function quinzaineAction(Request $req)
    {
        $odm = $this->get('doctrine_mongodb')->getManager();

        // Si c'est un apprenti, on choppe son livret
        // Si c'est un tuteur, on choppe le livret de son apprenti
        // Si c'est le RD, l'id de l'apprenti est passé en paramètre
        $securityContext = $this->container->get('security.authorization_checker');
        if ($securityContext->isGranted('ROLE_TUTEUR')) {
            $id = $this->getUser()->getId();
            $tuteur = $odm->getRepository("UtilisateurBundle:Utilisateur")->find(new \MongoId($id));
            $app = $tuteur->getApprentis();
            $apprenti = $odm->getRepository("UtilisateurBundle:Utilisateur")->findBy(array("email" => $app[0]));
            $apprenti = $apprenti[0];
            $id = $apprenti->getId();
        } else if ($securityContext->isGranted('ROLE_APPRENTI')) {
            $id = $this->getUser()->getId();
            $apprenti = $odm->getRepository("UtilisateurBundle:Utilisateur")->find(new \MongoId($id));
            $tuteur = $odm->getRepository("UtilisateurBundle:Utilisateur")->findBy(array("email" => $apprenti->getTuteur()[0]));
            $tuteur = $tuteur[0];
        } else if ($securityContext->isGranted('ROLE_RD')) {
            $id = $req->get('id');
            $apprenti = $odm->getRepository("UtilisateurBundle:Utilisateur")->find(new \MongoId($id));
            $tuteur = $odm->getRepository("UtilisateurBundle:Utilisateur")->findBy(array("email" => $apprenti->getTuteur()[0]));
            $tuteur = $tuteur[0];
        }


        $livret = $odm->getRepository("LivretBundle:Livret")->findOneBy(array("apprenti" => new \MongoId($id)));
        return $this->render('LivretBundle:Default:quinzaine.html.twig', array("livret" => $livret, "apprenti" => $apprenti, "tuteur" => $tuteur));
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
            $apprenti = $this->getUser();
            $livret = $odm->getRepository("LivretBundle:Livret")->findOneBy(array("apprenti" => new \MongoId($id)));
            $tuteur = $odm->getRepository("UtilisateurBundle:Utilisateur")->findOneBy(array("_id" => new \MongoId($livret->getTuteur())));
            $livret->setPeriodeFormation(array($p));

            $odm->persist($livret);
            $odm->flush();

            return $this->render('LivretBundle:Default:quinzaine.html.twig', array("livret" => $livret, 'apprenti' => $apprenti, 'tuteur' => $tuteur));
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

    public function consulterAction(Request $req)
    {
        $odm = $this->get('doctrine_mongodb')->getManager();

        // Si c'est un apprenti, on choppe son livret
        // Si c'est un tuteur, on choppe le livret de son apprenti
        // Si c'est le RD, l'id de l'apprenti est passé en paramètre
        if ($this->get('security.context')->isGranted('ROLE_TUTEUR')) {
            $id = $this->getUser()->getId();
            $tuteur = $odm->getRepository("UtilisateurBundle:Utilisateur")->find(new \MongoId($id));
            $apprenti = $odm->getRepository("UtilisateurBundle:Utilisateur")->findBy(array("email" => $tuteur->getApprentis()[0]));
            $id = $apprenti[0]->getId();
        } else if ($this->get('security.context')->isGranted('ROLE_APPRENTI')) {
            $id = $this->getUser()->getId();
        } else if ($this->get('security.context')->isGranted('ROLE_RD')) {
            $id = $req->get('id');
        }

        $livret = $odm->getRepository("LivretBundle:Livret")->findOneBy(array("apprenti" => new \MongoId($id)));

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

    public function exportAction()
    {
        $odm = $this->get('doctrine_mongodb')->getManager();
        $livret = $odm->getRepository("LivretBundle:Livret")->findOneBy(array('_id' => "568f899f2a1cb3e2058b4568"));

        $encoders = array(new XmlEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);

        $livretXML = $serializer->serialize($livret, 'xml');
        $livretXML = html_entity_decode($livretXML);

        $exportFile = $this->container->getParameter('kernel.root_dir') . '/../web/export/exportTest.xml';
        $myfile = fopen($exportFile, "w") or die("Unable to open file!");
        fwrite($myfile, $livretXML);
        fclose($myfile);

        return $this->render('LivretBundle:Default:exportLivret.html.twig', array("livretXML" => $livretXML));
    }

    public function saveLivretAction(Request $request)
    {
        $success = "";
        try {
            $data = $request->getContent();
            $data = json_decode($data);


            // On récupère l'item de la bdd qu'on souhaite modifier
            $odm = $this->get("doctrine_mongodb")->getManager();
//            $qb = $odm->createQueryBuilder('LivretBundle:Livret');
//            $livret = $qb->field("categorie.sections.itemLivret._id")->equals(new \MongoId($data->data->item))->getQuery()->execute();

            $livret = $odm->getRepository("LivretBundle:Livret")->findOneBy(array("_id" => new \MongoId($data->data->livret)));

            // on delete le livret pour le recreer apres, l'update ne marche pas pour les document embedded

            $l = $livret;

            $odm->remove($livret);
            $odm->flush();

            // On est bien dans le livret
            // Alors on update l'item on lui passant les param
            $l->updateItem($data);

            $odm->persist($l);
            $odm->flush();


            $success = true;
        } catch (Exception $e) {
            $success = $e->getMessage();
        }
        return $this->render('LivretBundle:Default/Ajax:action.html.twig', array("success" => $success, "livret" => $livret));
    }

    public function signerAction(Request $request)
    {
        try {
            $data = $request->getContent();
            $data = json_decode($data);
            $odm = $this->get("doctrine_mongodb")->getManager();
            $user = $odm->getRepository("UtilisateurBundle:Utilisateur")->find($this->getUser()->getId());
            $data->data->value = $user->getSignature();


            $livret = $odm->getRepository("LivretBundle:Livret")->findOneBy(array("_id" => new \MongoId($data->data->livret)));

            // on delete le livret pour le recreer apres, l'update ne marche pas pour les document embedded

            $l = $livret;


            $odm->remove($livret);
            $odm->flush();
            // On est bien dans le livret
            // Alors on update l'item on lui passant les param
            $l->updateItem($data);

            $odm->persist($l);
            $odm->flush();


        } catch
        (Exception $e) {
            $success = $e->getMessage();
        }

        return $this->consulterAction($request);
    }

    public function ajouterFichierAction(Request $request)
    {
        $data["data"]["item"] = $request->get("item");
        $data["data"]["livret"] = $request->get("livret");
        $data["data"]["categorie"] = $request->get("categorie");
        $data["data"]["section"] = $request->get("section");
        $data["data"]["key"] = $request->get("key");
        $file = $request->files->get('userfile');

        $data["data"]["value"] = $this->getUser()->getUsername() . "_" . $file->getClientOriginalName();
        $url = $this->container->getParameter('kernel.root_dir') . '/../web/uploads/itemlivret';;

        $file->move($url, $data["data"]["value"]);

        $data = json_encode($data);
        $data = json_decode($data);
        var_dump($data->data);

        $odm = $this->get("doctrine_mongodb")->getManager();
        $user = $odm->getRepository("UtilisateurBundle:Utilisateur")->find($this->getUser()->getId());
        $livret = $odm->getRepository("LivretBundle:Livret")->findOneBy(array("_id" => new \MongoId($data->data->livret)));

        // on delete le livret pour le recreer apres, l'update ne marche pas pour les document embedded
        $l = $livret;

        $odm->remove($livret);
        $odm->flush();
        // On est bien dans le livret
        // Alors on update l'item on lui passant les param
        $l->updateItem($data);

        $odm->persist($l);
        $odm->flush();



        return $this->consulterAction($request);


    }

}
