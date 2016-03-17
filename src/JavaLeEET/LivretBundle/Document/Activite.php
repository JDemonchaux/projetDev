<?php

namespace JavaLeEET\LivretBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * JavaLeEET\LivretBundle\Document\Activite
 *
 * @ODM\Document
 * @ODM\ChangeTrackingPolicy("DEFERRED_IMPLICIT")
 */
class Activite
{
    /**
     * @var MongoId $id
     *
     * @ODM\Id(strategy="AUTO")
     */
    protected $id;


    /**
     * @var string $titre
     *
     * @ODM\Field(name="titre", type="string")
     */
    protected $titre;

    /**
     * @var collection $descriptif
     *
     * @ODM\Field(name="descriptif", type="collection")
     */
    protected $descriptif;

    /**
     * @var collection $competences
     *
     * @ODM\EmbedMany(targetDocument="Competence")
     */
    protected $competences;

    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * @param string $titre
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
    }

    /**
     * @return collection
     */
    public function getCompetences()
    {
        return $this->competences;
    }

    /**
     * @param collection $competences
     */
    public function setCompetences($competences)
    {
        $this->competences = $competences;
    }

    /**
     * Set descriptif
     *
     * @param string $descriptif
     * @return self
     */
    public function setDescriptif($descriptif)
    {
        $this->descriptif = $descriptif;
        return $this;
    }

    /**
     * Get descriptif
     *
     * @return string $descriptif
     */
    public function getDescriptif()
    {
        return $this->descriptif;
    }
    public function __construct()
    {
        $this->competences = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add competence
     *
     * @param JavaLeEET\LivretBundle\Document\Competence $competence
     */
    public function addCompetence(\JavaLeEET\LivretBundle\Document\Competence $competence)
    {
        $this->competences[] = $competence;
    }

    /**
     * Remove competence
     *
     * @param JavaLeEET\LivretBundle\Document\Competence $competence
     */
    public function removeCompetence(\JavaLeEET\LivretBundle\Document\Competence $competence)
    {
        $this->competences->removeElement($competence);
    }
}
