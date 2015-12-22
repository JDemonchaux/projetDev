<?php

namespace JavaLeEET\LivretBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * JavaLeEET\LivretBundle\Document\CompetenceUtil
 *
 * @ODM\Document
 * @ODM\ChangeTrackingPolicy("DEFERRED_IMPLICIT")
 */
class CompetenceUtil
{
    /**
     * @var MongoId $id
     *
     * @ODM\Id(strategy="AUTO")
     */
    protected $id;

    /**
     * @var collection $competence
     *
     * @ODM\Field(name="competence", type="collection")
     */
    protected $competence;

    /**
     * @var integer $degreMaitrise
     *
     * @ODM\Field(name="degreMaitrise", type="integer")
     */
    protected $degreMaitrise;


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
     * Set competence
     *
     * @param collection $competence
     * @return self
     */
    public function setCompetence($competence)
    {
        $this->competence = $competence;
        return $this;
    }

    /**
     * Get competence
     *
     * @return collection $competence
     */
    public function getCompetence()
    {
        return $this->competence;
    }

    /**
     * Set degreMaitrise
     *
     * @param integer $degreMaitrise
     * @return self
     */
    public function setDegreMaitrise($degreMaitrise)
    {
        $this->degreMaitrise = $degreMaitrise;
        return $this;
    }

    /**
     * Get degreMaitrise
     *
     * @return integer $degreMaitrise
     */
    public function getDegreMaitrise()
    {
        return $this->degreMaitrise;
    }
}
