<?php

namespace JavaLeEET\UtilisateurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use JavaLeEET\UtilisateurBundle\Document\Signature;
use JavaLeEET\UtilisateurBundle\Form\SignatureType;
use JavaLeEET\UtilisateurBundle\Document\CSVFile;
use JavaLeEET\UtilisateurBundle\Form\CSVFileType;
use JavaLeEET\UtilisateurBundle\Document\Utilisateur;

class DefaultController extends Controller
{
    public function indexAction()
    {
        // Si l'utilisateur n'est pas connecté, on affiche la page de login
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            $url = $this->generateUrl("fos_user_security_login");
        } else {
            $url = $this->generateUrl("livret_homepage");
        }

        return $this->redirect($url);
    }

    public function importSignAction(Request $request)
    {
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
            // Generate a unique name for the file before saving it
            $fileName = md5(uniqid()) . '.' . $file->guessExtension();

            // Move the file to the directory where signatures are stored
            $signaturesDir = $this->container->getParameter('kernel.root_dir') . '/../web/uploads/signatures';
            $file->move($signaturesDir, $fileName);

            // Update the 'signature' property to store the new file name
            // instead of its contents
            $signature->setSignature($fileName);

            // ... persist the $signature variable if needed
            $user = $this->getUser();
            $user->setSignature($signature);

//             Commenté pour l'instant car la mise a jour vide l'utilisateur en bdd.
//            A voir donc une fois qu'on pourra importer les users.
//            $odm = $this->get('doctrine_mongodb')->getManager();
//            $odm->persist($user);
//            $odm->flush();

            // Si l'utilisateur n'est pas connecté, on affiche la page de login
            if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
                $url = $this->generateUrl("fos_user_security_login");
            } else {
                $url = $this->generateUrl("livret_homepage");
            }

            return $this->redirect($url);
        }

        return $this->render('UtilisateurBundle:Default:importSign.html.twig', array(
            'form' => $form->createView(),
        ));
    }


    public function importCSVAction(Request $request){

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
            if (($handle = fopen($csvDir.'/'.$fileName, "r")) !== FALSE) {
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $num = count($data);

                    $utilisateur = new Utilisateur();
                    $utilisateur->setUsername($data[0].".".$data[1]);
                    $utilisateur->setPrenom($data[0]);
                    $utilisateur->setNom($data[1]);
                    $utilisateur->setEmail($data[2]);
                    $utilisateur->setRoles(array($data[3]));
                    $utilisateur->setPlainPassword($data[4]);
                    for ($i = 5; $i < $num; $i++) { 
                        $utilisateur->addMailLink($data[$i]);
                    }
                    $utilisateur->setEnabled(true);
                    //Persister l'utilisateur
                    $odm->persist($utilisateur);
                    $odm->flush();
                }
                fclose($handle);
            }
            //Générer le livret de l'utilisateur

            return $this->redirect($this->generateUrl("livret_homepage"));
        }
        return $this->render('UtilisateurBundle:Default:importCSV.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
