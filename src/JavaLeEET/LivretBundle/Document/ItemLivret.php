<?php

namespace JavaLeEET\LivretBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * JavaLeEET\LivretBundle\Document\ItemLivret
 *
 * @ODM\Document
 * @ODM\ChangeTrackingPolicy("DEFERRED_IMPLICIT")
 */
class ItemLivret
{
    /**
     * @var MongoId $id
     *
     * @ODM\Id(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $typeVariable
     *
     * @ODM\Field(name="typeVariable", type="string")
     */
    protected $typeVariable;

    /**
     * @var string $valeurVariable
     *
     * @ODM\Field(name="valeurVariable", type="string")
     */
    protected $valeurVariable;


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
     * Set typeVariable
     *
     * @param string $typeVariable
     * @return self
     */
    public function setTypeVariable($typeVariable)
    {
        $this->typeVariable = $typeVariable;
        return $this;
    }

    /**
     * Get typeVariable
     *
     * @return string $typeVariable
     */
    public function getTypeVariable()
    {
        return $this->typeVariable;
    }

    /**
     * Set valeurVariable
     *
     * @param string $valeurVariable
     * @return self
     */
    public function setValeurVariable($valeurVariable)
    {
        $this->valeurVariable = $valeurVariable;
        return $this;
    }

    /**
     * Get valeurVariable
     *
     * @return string $valeurVariable
     */
    public function getValeurVariable()
    {
        return $this->valeurVariable;
    }
}
