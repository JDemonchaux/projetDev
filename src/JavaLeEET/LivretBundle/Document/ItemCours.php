<?php

namespace JavaLeEET\LivretBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * JavaLeEET\LivretBundle\Document\ItemCours
 *
 * @ODM\Document
 * @ODM\ChangeTrackingPolicy("DEFERRED_IMPLICIT")
 */
class ItemCours
{
    /**
     * @var MongoId $id
     *
     * @ODM\Id(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $moduleFormation
     *
     * @ODM\Field(name="moduleFormation", type="string")
     */
    protected $moduleFormation;

    /**
     * @var string $liensEntreprise
     *
     * @ODM\Field(name="liensEntreprise", type="string")
     */
    protected $liensEntreprise;

    /**
     * @var string $difficulte
     *
     * @ODM\Field(name="difficulte", type="string")
     */
    protected $difficulte;

    /**
     * @var string $experimentationEntreprise
     *
     * @ODM\Field(name="experimentationEntreprise", type="string")
     */
    protected $experimentationEntreprise;


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
     * Set moduleFormation
     *
     * @param string $moduleFormation
     * @return self
     */
    public function setModuleFormation($moduleFormation)
    {
        $this->moduleFormation = $moduleFormation;
        return $this;
    }

    /**
     * Get moduleFormation
     *
     * @return string $moduleFormation
     */
    public function getModuleFormation()
    {
        return $this->moduleFormation;
    }

    /**
     * Set liensEntreprise
     *
     * @param string $liensEntreprise
     * @return self
     */
    public function setLiensEntreprise($liensEntreprise)
    {
        $this->liensEntreprise = $liensEntreprise;
        return $this;
    }

    /**
     * Get liensEntreprise
     *
     * @return string $liensEntreprise
     */
    public function getLiensEntreprise()
    {
        return $this->liensEntreprise;
    }

    /**
     * Set difficulte
     *
     * @param string $difficulte
     * @return self
     */
    public function setDifficulte($difficulte)
    {
        $this->difficulte = $difficulte;
        return $this;
    }

    /**
     * Get difficulte
     *
     * @return string $difficulte
     */
    public function getDifficulte()
    {
        return $this->difficulte;
    }

    /**
     * Set experimentationEntreprise
     *
     * @param string $experimentationEntreprise
     * @return self
     */
    public function setExperimentationEntreprise($experimentationEntreprise)
    {
        $this->experimentationEntreprise = $experimentationEntreprise;
        return $this;
    }

    /**
     * Get experimentationEntreprise
     *
     * @return string $experimentationEntreprise
     */
    public function getExperimentationEntreprise()
    {
        return $this->experimentationEntreprise;
    }
}
