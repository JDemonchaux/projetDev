<?php

namespace JavaLeEET\LivretBundle\Document;



/**
 * JavaLeEET\LivretBundle\Document\Activite2
 */
class Activite2
{
    /**
     * @var $id
     */
    protected $id;

    /**
     * @var string $titre
     */
    protected $titre;

    /**
     * @var collection $descriptif
     */
    protected $descriptif;

    /**
     * @var JavaLeEET\LivretBundle\Document\Competence
     */
    protected $competences = array();

    public function __construct()
    {
        $this->competences = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
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
     * Set titre
     *
     * @param string $titre
     * @return self
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
        return $this;
    }

    /**
     * Get titre
     *
     * @return string $titre
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set descriptif
     *
     * @param collection $descriptif
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
     * @return collection $descriptif
     */
    public function getDescriptif()
    {
        return $this->descriptif;
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

    /**
     * Get competences
     *
     * @return \Doctrine\Common\Collections\Collection $competences
     */
    public function getCompetences()
    {
        return $this->competences;
    }
}