<?php

namespace JavaLeEET\Bundle\LivretBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * JavaLeEET\Bundle\LivretBundle\Document\PeriodeFormation
 *
 * @ODM\Document
 * @ODM\ChangeTrackingPolicy("DEFERRED_IMPLICIT")
 */
class PeriodeFormation
{
    /**
     * @var MongoId $id
     *
     * @ODM\Id(strategy="AUTO")
     */
    protected $id;

    /**
     * @var date $dateDebutF
     *
     * @ODM\Field(name="dateDebutF", type="date")
     */
    protected $dateDebutF;

    /**
     * @var date $dateDebutE
     *
     * @ODM\Field(name="dateDebutE", type="date")
     */
    protected $dateDebutE;

    /**
     * @var date $dateFin
     *
     * @ODM\Field(name="dateFin", type="date")
     */
    protected $dateFin;

    /**
     * @var collection $itemCours
     *
     * @ODM\Field(name="itemCours", type="collection")
     */
    protected $itemCours;

    /**
     * @var collection $itemEntreprise
     *
     * @ODM\Field(name="itemEntreprise", type="collection")
     */
    protected $itemEntreprise;

    /**
     * @var boolean $signatureRD
     *
     * @ODM\Field(name="signatureRD", type="boolean")
     */
    protected $signatureRD;

    /**
     * @var boolean $signatureTuteur
     *
     * @ODM\Field(name="signatureTuteur", type="boolean")
     */
    protected $signatureTuteur;

    /**
     * @var boolean $signatureApprenti
     *
     * @ODM\Field(name="signatureApprenti", type="boolean")
     */
    protected $signatureApprenti;


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
     * Set dateDebutF
     *
     * @param date $dateDebutF
     * @return self
     */
    public function setDateDebutF($dateDebutF)
    {
        $this->dateDebutF = $dateDebutF;
        return $this;
    }

    /**
     * Get dateDebutF
     *
     * @return date $dateDebutF
     */
    public function getDateDebutF()
    {
        return $this->dateDebutF;
    }

    /**
     * Set dateDebutE
     *
     * @param date $dateDebutE
     * @return self
     */
    public function setDateDebutE($dateDebutE)
    {
        $this->dateDebutE = $dateDebutE;
        return $this;
    }

    /**
     * Get dateDebutE
     *
     * @return date $dateDebutE
     */
    public function getDateDebutE()
    {
        return $this->dateDebutE;
    }

    /**
     * Set dateFin
     *
     * @param date $dateFin
     * @return self
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;
        return $this;
    }

    /**
     * Get dateFin
     *
     * @return date $dateFin
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * Set itemCours
     *
     * @param collection $itemCours
     * @return self
     */
    public function setItemCours($itemCours)
    {
        $this->itemCours = $itemCours;
        return $this;
    }

    /**
     * Get itemCours
     *
     * @return collection $itemCours
     */
    public function getItemCours()
    {
        return $this->itemCours;
    }

    /**
     * Set itemEntreprise
     *
     * @param collection $itemEntreprise
     * @return self
     */
    public function setItemEntreprise($itemEntreprise)
    {
        $this->itemEntreprise = $itemEntreprise;
        return $this;
    }

    /**
     * Get itemEntreprise
     *
     * @return collection $itemEntreprise
     */
    public function getItemEntreprise()
    {
        return $this->itemEntreprise;
    }

    /**
     * Set signatureRD
     *
     * @param boolean $signatureRD
     * @return self
     */
    public function setSignatureRD($signatureRD)
    {
        $this->signatureRD = $signatureRD;
        return $this;
    }

    /**
     * Get signatureRD
     *
     * @return boolean $signatureRD
     */
    public function getSignatureRD()
    {
        return $this->signatureRD;
    }

    /**
     * Set signatureTuteur
     *
     * @param boolean $signatureTuteur
     * @return self
     */
    public function setSignatureTuteur($signatureTuteur)
    {
        $this->signatureTuteur = $signatureTuteur;
        return $this;
    }

    /**
     * Get signatureTuteur
     *
     * @return boolean $signatureTuteur
     */
    public function getSignatureTuteur()
    {
        return $this->signatureTuteur;
    }

    /**
     * Set signatureApprenti
     *
     * @param boolean $signatureApprenti
     * @return self
     */
    public function setSignatureApprenti($signatureApprenti)
    {
        $this->signatureApprenti = $signatureApprenti;
        return $this;
    }

    /**
     * Get signatureApprenti
     *
     * @return boolean $signatureApprenti
     */
    public function getSignatureApprenti()
    {
        return $this->signatureApprenti;
    }
}
