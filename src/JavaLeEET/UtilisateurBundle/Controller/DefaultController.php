<?php

namespace JavaLeEET\UtilisateurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use JavaLeEET\UtilisateurBundle\Document\Signature;
use JavaLeEET\UtilisateurBundle\Form\SignatureType;
use JavaLeEET\UtilisateurBundle\Document\CSVFile;
use JavaLeEET\UtilisateurBundle\Form\CSVFileType;
use JavaLeEET\UtilisateurBundle\Document\Utilisateur;
use JavaLeEET\LivretBundle\Document\Livret;

class DefaultController extends Controller
{
    public function indexAction()
    {
        // Si l'utilisateur n'est pas connecté, on affiche la page de login
        $securityContext = $this->container->get('security.authorization_checker');
        if (!$securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $url = $this->generateUrl("fos_user_security_login");
        } else {
            $url = $this->generateUrl("livret_homepage");
        }

        return $this->redirect($url);
    }

    public function importSignAction(Request $request)
    {
        $securityContext = $this->container->get('security.authorization_checker');
        $signature = new Signature();
        $form = $this->createForm(new SignatureType(), $signature);
        $form->handleRequest($request);

        if ($request->getMethod() == "POST") {

            // $file stores the uploaded file
            /** @var Symfony\Component\HttpFoundation\File\UploadedFile $file */
            $file = $signature->getSignature();

            if ($file->guessExtension() != "png") {
                return $this->render('UtilisateurBundle:Default:importSign.html.twig', array(
                    'form' => $form->createView(),
                ));
        }

            // On get l'odm
            $odm = $this->get('doctrine_mongodb')->getManager();

            // On récupère l'user courant en base
            $user = $this->getUser();
            $user = $odm->getRepository("UtilisateurBundle:Utilisateur")->find($user->getId());

            // On nomme le fichier signature suivant l'username
            $fileName = $this->getUser()->getUsername() . '.' . $file->guessExtension();

            // Déplace le fichier signature de tmp aux assets
            $signaturesDir = $this->container->getParameter('kernel.root_dir') . '/../web/uploads/signatures';
            $file->move($signaturesDir, $fileName);

            // Enfin on rentre le nom du fichier dans notre objet utilisateur
            $user->setSignature($fileName);

            // On update, vu qu'on a déjà recupéré l'user depuis la bdd il est déjà managé, un flush suffit
            $odm->flush();

            // Si l'utilisateur n'est pas connecté, on affiche la page de login
            if (!$securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
                $url = $this->generateUrl("fos_user_security_login");
            } else {
                $url = $this->generateUrl("livret_homepage");
            }
//
            return $this->redirect($url);
        }

        return $this->render('UtilisateurBundle:Default:importSign.html.twig', array(
            'form' => $form->createView(),
        ));
    }


    public function importCSVAction(Request $request)
    {

        $csvFile = new CSVFile();
        $form = $this->createForm(new CSVFileType(), $csvFile);
        $form->handleRequest($request);

        if ($request->getMethod() == "POST") {
            $file = $csvFile->getCsvFile();

            if ($file->getClientOriginalExtension() != "csv") {
                return $this->render('UtilisateurBundle:Default:importCSV.html.twig', array(
                    'form' => $form->createView(),
                ));
            }

            // Generate a unique name for the file before saving it
            $fileName = 'Utilisateur.' . $file->getClientOriginalExtension();

            // Move the file to the directory where signatures are stored
            $csvDir = $this->container->getParameter('kernel.root_dir') . '/../web/uploads/csv';
            $file->move($csvDir, $fileName);

            // Update the 'signature' property to store the new file name
            // instead of its contents
            $csvFile->setCsvFile($fileName);

            $odm = $this->get('doctrine_mongodb')->getManager();
            //Parser csv
            if (($handle = fopen($csvDir . '/' . $fileName, "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $num = count($data);

                    $data[0] = ucwords($data[0]);
                    $data[1] = ucwords($data[1]);

                    $utilisateur = new Utilisateur();
                    $utilisateur->setUsername($data[0] . "." . $data[1]);
                    $utilisateur->setPrenom($data[0]);
                    $utilisateur->setNom($data[1]);
                    $utilisateur->setEmail($data[2]);
                    $utilisateur->setRoles(array($data[3]));
                    $utilisateur->setPlainPassword($data[4]);
                    if ($data[3] !== "ROLE_RD") {
                        if ($data[3] == "ROLE_TUTEUR") {
                            for ($i = 5; $i < $num; $i++) {
                                $utilisateur->setApprentis(array($data[$i]));
                            }
                        } else if ($data[3] == "ROLE_APPRENTI") {
                            $utilisateur->setTuteur(array($data[5]));
                            $utilisateur->setClasse($data[6]);
                        }
                    }
                    $utilisateur->setEnabled(true);
                    //Persister l'utilisateur
                    $odm->persist($utilisateur);
                    $odm->flush();
                    if ($data[3] == "ROLE_APPRENTI") {
                        $user = $odm->getRepository("UtilisateurBundle:Utilisateur")->findOneBy(array("email" => $data[2]));

                        //Générer le livret de l'utilisateur
                        $livret = new Livret();
                        $livret->genererLivret($user->getId());

                        //Persister le livret
                        $odm->persist($livret);
                        $odm->flush();
                    }
                }
                fclose($handle);
            }
            $this->associerTuteur();
            return $this->redirect($this->generateUrl("utilisateur_homepage"));
        }
        return $this->render('UtilisateurBundle:Default:importCSV.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function associerTuteur(){
        $odm = $this->get('doctrine_mongodb')->getManager();
        $apprentis = $odm->getRepository("UtilisateurBundle:Utilisateur")->findBy(array("roles" => "ROLE_APPRENTI"));
        foreach ($apprentis as $apprenti) {
            $tuteur = $apprenti->getTuteur();
            $tuteur = $odm->getRepository("UtilisateurBundle:Utilisateur")->findOneBy(array("email" => $tuteur[0]));
            $tuteur = $tuteur->getId();

            $apprentiId = $apprenti->getId();
            $livret = $odm->getRepository("LivretBundle:Livret")->findOneBy(array("apprenti" => new \MongoId($apprentiId)));
            
            $livret->setTuteur($tuteur);
            $odm->persist($livret);
            $odm->flush();
        }
    }
}
