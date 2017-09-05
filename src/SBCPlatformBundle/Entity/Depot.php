<?php

namespace SBCPlatformBundle\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Depot
 *
 * @ORM\Table(name="depot")
 * @ORM\Entity(repositoryClass="SBCPlatformBundle\Repository\DepotRepository")
 */
class Depot extends Emplacement
{


}
