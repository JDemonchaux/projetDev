<?php

namespace JavaLeEET\Bundle\UtilisateurBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use JavaLeEET\Bundle\UtilisateurBundle\Document\Signature;
use JavaLeEET\Bundle\UtilisateurBundle\Form\SignatureType;

class DefaultController extends Controller
{
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
            $fileName = md5(uniqid()).'.'.$file->guessExtension();

            // Move the file to the directory where signatures are stored
            $signaturesDir = $this->container->getParameter('kernel.root_dir').'/../web/uploads/signatures';
            $file->move($signaturesDir, $fileName);

            // Update the 'signature' property to store the new file name
            // instead of its contents
            $signature->setSignature($fileName);

            // ... persist the $signature variable if needed

            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }

        return $this->render('UtilisateurBundle:Default:importSign.html.twig', array(
            'form' => $form->createView(),
        ));
    }
}
