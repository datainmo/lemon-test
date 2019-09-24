<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 */
class SearchPerson
{

    private $nationality;


    public function getNationality(): ?string
    {
        return $this->nationality;
    }

    public function setNationality(string $nationality): self
    {
        $this->nationality = $nationality;

        return $this;
    }
}
