<?php 

namespace App\Entity;

use DateTime;

class EventSearch{
    /**
     * @var String|null
     */
    private $lieux;

    /**
     * @var DateTime|null
     */
    private $date;

    /**
     * @var String|null
     */
    private $type;

    public function getLieux() : ?String
    {
        return $this->lieux;
    }

    public function setLieux(String $lieux) : EventSearch
    {
        $this->lieux=$lieux;
        return $this;
    }

    public function getDate() : ?DateTime
    {
        return $this->lieux;
    }

    public function setDate($lieux) : EventSearch
    {
        $this->lieux=$lieux;
        return $this;
    }

    public function getType() : ?String
    {
        return $this->lieux;
    }

    public function setType(String $lieux) : EventSearch
    {
        $this->lieux=$lieux;
        return $this;
    }
}