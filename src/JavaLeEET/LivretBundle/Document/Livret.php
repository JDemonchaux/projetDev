<?php

namespace JavaLeEET\LivretBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * JavaLeEET\LivretBundle\Document\Livret
 *
 * @ODM\Document
 * @ODM\ChangeTrackingPolicy("DEFERRED_IMPLICIT")
 */
class Livret
{
    /**
     * @var MongoId $id
     *
     * @ODM\Id(strategy="AUTO")
     */
    protected $id;

    /**
     * @var object_id $apprenti
     *
     * @ODM\Field(name="apprenti", type="object_id")
     */
    protected $apprenti;

    /**
     * @var object_id $tuteur
     *
     * @ODM\Field(name="tuteur", type="object_id")
     */
    protected $tuteur;

    /**
     * @var collection $categorie
     *
     * @ODM\Field(name="categorie", type="collection")
     */
    protected $categorie;

    /**
     * @var collection $periodeFormation
     *
     * @ODM\Field(name="periodeFormation", type="collection")
     */
    protected $periodeFormation;


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
     * Set apprenti
     *
     * @param object_id $apprenti
     * @return self
     */
    public function setApprenti($apprenti)
    {
        $this->apprenti = $apprenti;
        return $this;
    }

    /**
     * Get apprenti
     *
     * @return object_id $apprenti
     */
    public function getApprenti()
    {
        return $this->apprenti;
    }

    /**
     * Set tuteur
     *
     * @param object_id $tuteur
     * @return self
     */
    public function setTuteur($tuteur)
    {
        $this->tuteur = $tuteur;
        return $this;
    }

    /**
     * Get tuteur
     *
     * @return object_id $tuteur
     */
    public function getTuteur()
    {
        return $this->tuteur;
    }

    /**
     * Set categorie
     *
     * @param collection $categorie
     * @return self
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;
        return $this;
    }

    /**
     * Get categorie
     *
     * @return collection $categorie
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * Set periodeFormation
     *
     * @param collection $periodeFormation
     * @return self
     */
    public function setPeriodeFormation($periodeFormation)
    {
        $this->periodeFormation = $periodeFormation;
        return $this;
    }

    /**
     * Get periodeFormation
     *
     * @return collection $periodeFormation
     */
    public function getPeriodeFormation()
    {
        return $this->periodeFormation;
    }
}
