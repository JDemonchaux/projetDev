<?php

namespace JavaLeEET\Bundle\LivretBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * JavaLeEET\Bundle\LivretBundle\Document\Section
 *
 * @ODM\Document
 * @ODM\ChangeTrackingPolicy("DEFERRED_IMPLICIT")
 */
class Section
{
    /**
     * @var MongoId $id
     *
     * @ODM\Id(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $nom
     *
     * @ODM\Field(name="nom", type="string")
     */
    protected $nom;

    /**
     * @var collection $itemLivret
     *
     * @ODM\Field(name="itemLivret", type="collection")
     */
    protected $itemLivret;


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
     * Set nom
     *
     * @param string $nom
     * @return self
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
        return $this;
    }

    /**
     * Get nom
     *
     * @return string $nom
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set itemLivret
     *
     * @param collection $itemLivret
     * @return self
     */
    public function setItemLivret($itemLivret)
    {
        $this->itemLivret = $itemLivret;
        return $this;
    }

    /**
     * Get itemLivret
     *
     * @return collection $itemLivret
     */
    public function getItemLivret()
    {
        return $this->itemLivret;
    }
}
