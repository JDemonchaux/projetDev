<?php

namespace JavaLeEET\UtilisateurBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * JavaLeEET\UtilisateurBundle\Document\CSVFile
 *
 * @ODM\Document(
 *     repositoryClass="JavaLeEET\UtilisateurBundle\Document\CSVFileRepository"
 * )
 * @ODM\ChangeTrackingPolicy("DEFERRED_IMPLICIT")
 */
class CSVFile
{
    /**
     * @var MongoId $id
     *
     * @ODM\Id(strategy="AUTO")
     */
    protected $id;

    /**
     * @var file $csvFile
     *
     * @ODM\Field(name="file", type="file")
     */
    protected $csvFile;


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
     * Set csvFile
     *
     * @param file $csvFile
     * @return self
     */
    public function setCsvFile($csvFile)
    {
        $this->csvFile = $csvFile;
        return $this;
    }

    /**
     * Get csvFile
     *
     * @return file $csvFile
     */
    public function getCsvFile()
    {
        return $this->csvFile;
    }
}
