<?php 

namespace App\Entity;

use DateTime;

class EventSearch{
    /**
     * @var String|null
     */
    private $lieux;

    public function getLieux() : ?String
    {
        return $this->lieux;
    }

    public function setLieux(String $lieux) : EventSearch
    {
        $this->lieux=$lieux;
        return $this;
    }
}