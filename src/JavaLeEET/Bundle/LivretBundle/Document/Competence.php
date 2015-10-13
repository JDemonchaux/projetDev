<?php

namespace JavaLeEET\Bundle\LivretBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * JavaLeEET\Bundle\LivretBundle\Document\Competence
 *
 * @ODM\Document
 * @ODM\ChangeTrackingPolicy("DEFERRED_IMPLICIT")
 */
class Competence
{
    /**
     * @var MongoId $id
     *
     * @ODM\Id(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $code
     *
     * @ODM\Field(name="code", type="string")
     */
    protected $code;

    /**
     * @var string $descriptif
     *
     * @ODM\Field(name="descriptif", type="string")
     */
    protected $descriptif;


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
     * Set code
     *
     * @param string $code
     * @return self
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * Get code
     *
     * @return string $code
     */
    public function getCode()
    {
        return $this->code;
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
}
