<?php

namespace JavaLeEET\LivretBundle\Controller;

use Doctrine\ODM\MongoDB\Mapping\Annotations\ObjectId;
use Doctrine\ODM\MongoDB\Types\ObjectIdType;
use Hydrators\JavaLeEETLivretBundleDocumentItemEntrepriseHydrator;
use JavaLeEET\LivretBundle\Document\Categorie;
use JavaLeEET\LivretBundle\Document\Competence;
use JavaLeEET\LivretBundle\Document\ItemEntreprise;
use JavaLeEET\LivretBundle\Document\Livret;
use JavaLeEET\LivretBundle\Document\PeriodeFormation;
use JavaLeEET\LivretBundle\Document\Section;
use MongoDBODMProxies\__CG__\JavaLeEET\LivretBundle\Document\CompetenceUtil;
use MongoDBODMProxies\__CG__\JavaLeEET\LivretBundle\Document\ItemCours;
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

    public function aide_consultationAction()
    {
        return $this->render('LivretBundle:Default:Help/aide_consultation.html.twig');
    }

    public function aideNavigationAction()
    {
        return $this->render('LivretBundle:Default:Help/aidenavigation.html.twig');
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
            $periodeFormation = new PeriodeFormation();
            $periodeFormation->setDateDebutE($dde);
            $periodeFormation->setDateDebutF($ddf);
            $periodeFormation->setDateFinE($dfe);
            $periodeFormation->setDateFinF($dff);
            $periodeFormation->setItemCours(null);
            $periodeFormation->setItemEntreprise(null);

            $odm = $this->get('doctrine_mongodb')->getManager();
            $id = $this->getUser()->getId();
            $apprenti = $this->getUser();
            $livret = $odm->getRepository("LivretBundle:Livret")->findOneBy(array("apprenti" => new \MongoId($id)));
            $tuteur = $odm->getRepository("UtilisateurBundle:Utilisateur")->findOneBy(array("_id" => new \MongoId($livret->getTuteur())));

            $l = $livret;
            $l->addPeriodeFormation($periodeFormation);

            $periodes = array();

            foreach ($livret->getPeriodeFormation()->getMongoData() as $periode) {

                if (isset($periode["_id"])) {
                    $p = new PeriodeFormation();
                    $p->setDateDebutF($periode["dateDebutF"]);
                    $p->setDateDebutE($periode["dateDebutE"]);
                    $p->setDateFinF($periode["dateFinF"]);
                    $p->setDateFinE($periode["dateFinE"]);
                    $itemsCours = array();
                    if (isset($periode["itemCours"])) {
                        foreach ($periode["itemCours"] as $ic) {
                            $i = new \JavaLeEET\LivretBundle\Document\ItemCours();
                            $i->setDifficulte($ic["difficulte"]);
                            $i->setModuleFormation($ic["moduleFormation"]);
                            $i->setExperimentationEntreprise($ic["experimentationEntreprise"]);
                            $i->setLiensEntreprise($ic["liensEntreprise"]);
                            $itemsCours[] = $i;
                        }
                        $p->setItemCours($itemsCours);
                    }

                    $itemEntreprise = array();
                    if (isset($periode["itemEntreprise"])) {
                        foreach ($periode["itemEntreprise"] as $ie) {
                            $i = new ItemEntreprise();
                            $i->setAptitudeRelationnelle($ie["aptitudeRelationnelle"]);
                            $i->setDescriptionActivite($ie["descriptionActivite"]);
                            $i->setLibelleActivite($ie["libelleActivite"]);
                            $i->setSavoirTheorique($ie["savoirTheorique"]);
                            $comp = array();
                            if (isset($ie["competencesUtil"])) {
                                foreach ($ie["competencesUtil"] as $cu) {
                                    $c = new \JavaLeEET\LivretBundle\Document\CompetenceUtil();
                                    $tempComp = array();
                                    foreach ($cu["competence"] as $tmp) {
                                        $tempComp[] = $tmp;
                                    }
                                    $c->setCompetence($tempComp);
                                    $c->setDegreMaitrise($cu["degreMaitrise"]);
                                    if (isset($cu["description"])) {
                                        $c->setDescription($cu["description"]);
                                    }
                                    $comp[] = $c;
                                }
                                $i->setCompetencesUtil($comp);
                            }

                            $itemEntreprise[] = $i;
                        }
                        $p->setItemEntreprise($itemEntreprise);
                    }
                    $periodes[] = $p;
                }
            }
            $periodes[] = $periodeFormation;
            $livret->setPeriodeFormation($periodes);
            $odm->flush();
        }
        $url = $this->generateUrl("livret_quinzaine");
        return $this->redirect($url);
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
        $securityContext = $this->container->get('security.authorization_checker');

        // Si c'est un apprenti, on choppe son livret
        // Si c'est un tuteur, on choppe le livret de son apprenti
        // Si c'est le RD, l'id de l'apprenti est passé en paramètre
        if ($securityContext->isGranted('ROLE_TUTEUR')) {
            $id = $this->getUser()->getId();
            $tuteur = $odm->getRepository("UtilisateurBundle:Utilisateur")->find(new \MongoId($id));
            $apprenti = $odm->getRepository("UtilisateurBundle:Utilisateur")->findBy(array("email" => $tuteur->getApprentis()[0]));
            $id = $apprenti[0]->getId();
        } else if ($securityContext->isGranted('ROLE_APPRENTI')) {
            $id = $this->getUser()->getId();
        } else if ($securityContext->isGranted('ROLE_RD')) {
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

            if (!$user->getSignature()) {
                // Renvoie sur la consult du livret, permet de mettre la requête ajax en err
                return $this->consulterAction($request);
            }

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
        } catch
        (Exception $e) {
            $success = $e->getMessage();
        }
        return $this->render('LivretBundle:Default/Ajax:action.html.twig', array("success" => $success));
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


    public function addItemFormationAction(Request $request)
    {
        $module = $request->request->get("module");
        $lien = $request->request->get("lienEntreprise");
        $difficulte = $request->request->get("difficulte");
        $exp = $request->request->get("experimenter");
        $idPeriode = $request->request->get("idPeriode");

        $item = new ItemCours();
        $item->setModuleFormation($module);
        $item->setExperimentationEntreprise($exp);
        $item->setDifficulte($difficulte);
        $item->setLiensEntreprise($lien);


        $odm = $this->get("doctrine_mongodb")->getManager();
        $livret = $odm->getRepository("LivretBundle:Livret")->findOneBy(array("apprenti" => new \MongoId($this->getUser()->getId())));
        $l = $livret;

        $odm->remove($livret);
        $odm->flush();

        $l->addItemCours($idPeriode, $item);

        $odm->persist($l);
        $odm->flush();

        return $this->redirect($this->generateUrl("livret_quinzaine"));

    }

    public function removeItemFormationAction(Request $request)
    {
        $idItem = new \MongoId($request->get("idItem"));
        $odm = $this->get("doctrine_mongodb")->getManager();
        $user = $odm->getRepository("UtilisateurBundle:Utilisateur")->find($this->getUser()->getId());
        $livret = $odm->getRepository("LivretBundle:Livret")->findOneBy(array("apprenti" => new \MongoId($this->getUser()->getId())));
        $l = $livret;

        $odm->remove($livret);
        $odm->flush();

        $l->removeItemCours($idItem);

        $odm->persist($l);
        $odm->flush();

        return $this->redirect($this->generateUrl("livret_quinzaine"));
    }

    public function addItemEntrepriseAction(Request $request)
    {
        $odm = $this->get("doctrine_mongodb")->getManager();
        $intitule = $request->request->get("intitule");
        $description = $request->request->get("description");
        $savoirfaire = $request->request->get("savoirfaire");
        $savoiretre = $request->request->get("savoiretre");
        $competences = $request->request->get("comp");
        $idPeriode = $request->request->get("idPeriode");

        $itemEntreprise = new ItemEntreprise();
        $itemEntreprise->setLibelleActivite($intitule);
        $itemEntreprise->setDescriptionActivite($description);
        $itemEntreprise->setSavoirTheorique($savoirfaire);
        $itemEntreprise->setAptitudeRelationnelle($savoiretre);

        $a = array();
        foreach ($competences as $c) {
            $competenceUtil = new \JavaLeEET\LivretBundle\Document\CompetenceUtil();
            $competenceUtil->setCompetence(array($c));
            $competenceUtil->setDegreMaitrise(0);
            array_push($a, $competenceUtil);
        }

        $itemEntreprise->setCompetencesUtil($a);

        $user = $odm->getRepository("UtilisateurBundle:Utilisateur")->find($this->getUser()->getId());
        $livret = $odm->getRepository("LivretBundle:Livret")->findOneBy(array("apprenti" => new \MongoId($this->getUser()->getId())));
        $l = $livret;


        $odm->remove($livret);
        $odm->flush();

        $l->addItemEntreprise($idPeriode, $itemEntreprise);

        $odm->persist($l);
        $odm->flush();

        return $this->redirect($this->generateUrl("livret_quinzaine"));

    }

    public function removeItemEntrepriseAction(Request $request)
    {
        $idItem = new \MongoId($request->get("idItem"));
        $odm = $this->get("doctrine_mongodb")->getManager();
        $user = $odm->getRepository("UtilisateurBundle:Utilisateur")->find($this->getUser()->getId());
        $livret = $odm->getRepository("LivretBundle:Livret")->findOneBy(array("apprenti" => new \MongoId($this->getUser()->getId())));
        $l = $livret;

        $odm->remove($livret);
        $odm->flush();

        $l->removeItemEntreprise($idItem);

        $odm->persist($l);
        $odm->flush();

        return $this->redirect($this->generateUrl("livret_quinzaine"));
    }

    public function addItemTuteurAction(Request $request)
    {

    }

    public function addMaitriseCompAction(Request $request)
    {
        try {
            $data = $request->getContent();
            $data = json_decode($data);

            $idLivret = $data->data->idLivret;
            $ids["periode"] = $data->data->idPeriode;
            $ids["itemEntreprise"] = $data->data->idItem;
            $ids["competenceUtil"] = $data->data->idComp;
            $degreMaitrise = $data->data->degreMaitrise;

            $odm = $this->get("doctrine_mongodb")->getManager();
            $livret = $odm->getRepository("LivretBundle:Livret")->findOneBy(array("id" => new \MongoId($idLivret)));
            $l = $livret;

            $odm->remove($livret);
            $odm->flush();

            $l->noterCompetence($ids, $degreMaitrise);

            $odm->persist($l);
            $odm->flush();

            $success = true;
        } catch
        (Exception $e) {
            $success = $e->getMessage();
        }

        return $this->render('LivretBundle:Default/Ajax:action.html.twig', array("success" => $success));
    }


    public function addDescriptionCompAction(Request $request)
    {
        try {
            $data = $request->getContent();
            $data = json_decode($data);

            $idPeriode = $data->data->idPeriode;
            $idLivret = $data->data->idLivret;
            $idComp = $data->data->idComp;
            $idItem = $data->data->idItem;
            $desc = $data->data->description;

            $odm = $this->get("doctrine_mongodb")->getManager();
            $livret = $odm->getRepository("LivretBundle:Livret")->findOneBy(array("id" => new \MongoId($idLivret)));
            $l = $livret;

            $odm->remove($livret);
            $odm->flush();

            $l->addDescriptionCompetence($idPeriode, $idComp, $idItem, $desc);

//            foreach ($l->getPeriodeFormation()->first()->getItemEntreprise()->first()->getCompetencesUtil() as $c) {
//                if ($c->getId() == $idComp) {
//                    $c->setDescription($desc);
//                }
//            }

            $odm->persist($l);
            $odm->flush();

            $success = true;
        } catch
        (Exception $e) {
            $success = $e->getMessage();
        }

        return $this->render('LivretBundle:Default/Ajax:action.html.twig', array("success" => $success));
    }

    public function addConclusionAction(Request $request)
    {
        $success = false;
        try {
            $data = $request->getContent();
            $data = json_decode($data);

            $idLivret = $data->data->idLivret;
            $idPeriode = $data->data->idPeriode;
            $conclusion = $data->data->conclusion;

            $odm = $this->get("doctrine_mongodb")->getManager();
            $livret = $odm->getRepository("LivretBundle:Livret")->findOneBy(array("id" => new \MongoId($idLivret)));
            $l = $livret;

            $odm->remove($livret);
            $odm->flush();

            $l->redigerConclusion($idPeriode, $conclusion);

            $odm->persist($l);
            $odm->flush();
            $success = true;
        } catch (Exception $e) {
            $success = $e->getMessage();
        }


        return $this->render('LivretBundle:Default/Ajax:action.html.twig', array("success" => $success));
    }


}
