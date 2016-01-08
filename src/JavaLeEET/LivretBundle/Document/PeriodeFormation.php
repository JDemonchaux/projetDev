<?php

namespace JavaLeEET\LivretBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * JavaLeEET\LivretBundle\Document\PeriodeFormation
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
     * @var date $dateFinF
     *
     * @ODM\Field(name="dateFinF", type="date")
     */
    protected $dateFinF;

    /**
     * @var date $dateFinE
     *
     * @ODM\Field(name="dateFinE", type="date")
     */
    protected $dateFinE;

    /**
     * @return date
     */
    public function getDateFinF()
    {
        return $this->dateFinF;
    }

    /**
     * @param date $dateFinF
     */
    public function setDateFinF($dateFinF)
    {
        $this->dateFinF = $dateFinF;
    }

    /**
     * @return date
     */
    public function getDateFinE()
    {
        return $this->dateFinE;
    }

    /**
     * @param date $dateFinE
     */
    public function setDateFinE($dateFinE)
    {
        $this->dateFinE = $dateFinE;
    }

    /**
     * @var collection $itemCours
     *
     * @ODM\EmbedMany(targetDocument="ItemCours")
     */
    protected $itemCours;

    /**
     * @var collection $itemEntreprise
     *
     * @ODM\EmbedMany(targetDocument="ItemEntreprise")
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
    public function __construct()
    {
        $this->itemCours = new \Doctrine\Common\Collections\ArrayCollection();
        $this->itemEntreprise = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Add itemCour
     *
     * @param JavaLeEET\LivretBundle\Document\ItemCours $itemCour
     */
    public function addItemCour(\JavaLeEET\LivretBundle\Document\ItemCours $itemCour)
    {
        $this->itemCours[] = $itemCour;
    }

    /**
     * Remove itemCour
     *
     * @param JavaLeEET\LivretBundle\Document\ItemCours $itemCour
     */
    public function removeItemCour(\JavaLeEET\LivretBundle\Document\ItemCours $itemCour)
    {
        $this->itemCours->removeElement($itemCour);
    }

    /**
     * Add itemEntreprise
     *
     * @param JavaLeEET\LivretBundle\Document\ItemEntreprise $itemEntreprise
     */
    public function addItemEntreprise(\JavaLeEET\LivretBundle\Document\ItemEntreprise $itemEntreprise)
    {
        $this->itemEntreprise[] = $itemEntreprise;
    }

    /**
     * Remove itemEntreprise
     *
     * @param JavaLeEET\LivretBundle\Document\ItemEntreprise $itemEntreprise
     */
    public function removeItemEntreprise(\JavaLeEET\LivretBundle\Document\ItemEntreprise $itemEntreprise)
    {
        $this->itemEntreprise->removeElement($itemEntreprise);
    }
}
