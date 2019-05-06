<?php


namespace AppBundle\Entity;


use AppBundle\Exception\NotABuffetException;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="enclosure")
 */
class Enclosure
{
    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Dinosaur", mappedBy="enclosure", cascade={"persist"})
     */
    private $dinosaurs;

    public function __construct()
    {
        $this->dinosaurs = new ArrayCollection();
    }

    /**
     * @return ArrayCollection
     */
    public function getDinosaurs(): ArrayCollection
    {
        return $this->dinosaurs;
    }

    /**
     * @param Dinosaur $dinosaur
     * @throws NotABuffetException
     */
    public function addDinosaur(Dinosaur $dinosaur)
    {
        if (!$this->canAddDinosaur($dinosaur)) {
           throw new NotABuffetException();
        }

        $this->dinosaurs[] = $dinosaur;
    }

    private function canAddDinosaur(Dinosaur $dinosaur)
    {
        return count($this->getDinosaurs()) == 0 || $this->getDinosaurs()->first()->isCarnivorous() == $dinosaur->isCarnivorous();
    }

}
