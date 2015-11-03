<?php

namespace JavaLeEET\UtilisateurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use JavaLeEET\UtilisateurBundle\Document\Signature;
use JavaLeEET\UtilisateurBundle\Form\SignatureType;

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
        if (!$this->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl("fos_user_security_login"));
        }
        
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
            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            // Move the file to the directory where signatures are stored
            $signaturesDir = $this->container->getParameter('kernel.root_dir').'/../web/uploads/signatures';
            $file->move($signaturesDir, $fileName);

            // Update the 'signature' property to store the new file name
            // instead of its contents
            $signature->setSignature($fileName);

            // ... persist the $signature variable if needed

            return $this->redirect($this->generateUrl("livret_homepage"));
        }

        return $this->render('UtilisateurBundle:Default:importSign.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
