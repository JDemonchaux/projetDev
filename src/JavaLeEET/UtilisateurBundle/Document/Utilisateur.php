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
     * @MongoDB\String
     */
    protected $signature;

    /**
     * @MongoDB\Field(name="apprentis", type="collection")
     */
    protected $apprentis;

    /**
     * @MongoDB\Field(name="tuteur", type="collection")
     */
    protected $tuteur;

    /**
     * @MongoDB\Field(name="classe", type="string")
     */
    protected $classe;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param mixed $nom
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    }

    /**
     * @return mixed
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * @param mixed $prenom
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;
    }

    /**
     * @return mixed
     */
    public function getMailLink()
    {
        return $this->mailLink;
    }

    /**
     * @param mixed $mail
     */
    public function addMailLink($mailLink)
    {
        $this->mailLink[] = $mailLink;
    }

    /**
     * @return mixed
     */
    public function getMail()
    {
        return $this->mail;
    }

    /**
     * @param mixed $mail
     */
    public function setMail($mail)
    {
        $this->mail = $mail;
    }

    /**
     * @return mixed
     */
    public function getMotDePasse()
    {
        return $this->motDePasse;
    }

    /**
     * @param mixed $motDePasse
     */
    public function setMotDePasse($motDePasse)
    {
        $this->motDePasse = $motDePasse;
    }

    /**
     * @return mixed
     */
    public function getSignature()
    {
        return $this->signature;
    }

    /**
     * @param mixed $signature
     */
    public function setSignature($signature)
    {
        $this->signature = $signature;
    }

    /**
     * @return mixed
     */
    public function getApprentis()
    {
        return $this->apprentis;
    }

    /**
     * @param mixed $apprentis
     */
    public function setApprentis($apprentis)
    {
        $this->apprentis = $apprentis;
    }

    /**
     * @return mixed
     */
    public function getTuteur()
    {
        return $this->tuteur;
    }

    /**
     * @param mixed $tuteur
     */
    public function setTuteur($tuteur)
    {
        $this->tuteur = $tuteur;
    }

    /**
     * @return mixed
     */
    public function getClasse()
    {
        return $this->classe;
    }

    /**
     * @param mixed $classe
     */
    public function setClasse($classe)
    {
        $this->classe = $classe;
    }



}
