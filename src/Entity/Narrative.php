<?php

namespace App\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Entity\Abstraction\AbstractUniqueEntity;
use App\Entity\Composition\TreeEntityTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass="App\Repository\NarrativeRepository")
 * @Gedmo\Tree(type="nested")
 */
class Narrative extends AbstractUniqueEntity
{
    use TreeEntityTrait;
}
