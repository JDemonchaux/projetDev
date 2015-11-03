<?php

namespace JavaLeEET\UtilisateurBundle\Document;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document(
 * collection="Utilisateurs"
 * )
 */
class Utilisateur extends BaseUser
{
    /**
     * @MongoDB\Id(strategy="auto")
     */
    protected $id;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * @MongoDB\String
     */
    protected $nom;

    /**
     * @MongoDB\String
     */
    protected $prenom;

    /**
     * @MongoDB\String
     */
    protected $mail;

    /**
     * @MongoDB\String
     */
    protected $motDePasse;

    /**
     * @MongoDB\File
     */
    protected $signature;
}