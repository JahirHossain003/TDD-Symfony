<?php


namespace AppBundle\Entity;


use AppBundle\Exception\DinosaursAreRunningRampantException;
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

    /**
     * @var ArrayCollection|Security[]
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Security", mappedBy="enclosure", cascade={"persist"})
     */
    private $securities;

    public function __construct(bool $addBasicSecurity = false)
    {
        $this->dinosaurs = new ArrayCollection();
        $this->securities = new ArrayCollection();

        if ($addBasicSecurity) {
            $this->addSecurity(new Security('Fence',true,$this));
        }
    }

    /**
     * @return ArrayCollection
     */
    public function getDinosaurs(): ArrayCollection
    {
        return $this->dinosaurs;
    }

    /**
     * @return ArrayCollection
     */
    public function getSecurities(): ArrayCollection
    {
        return $this->securities;
    }

    /**
     * @param Dinosaur $dinosaur
     * @throws NotABuffetException
     * @throws DinosaursAreRunningRampantException
     */
    public function addDinosaur(Dinosaur $dinosaur)
    {
        if (!$this->canAddDinosaur($dinosaur)) {
            throw new NotABuffetException();
        }

        if (!$this->isSecurityActive()) {
            throw new DinosaursAreRunningRampantException('Are you carzzy ?!?');
        }

        $this->dinosaurs[] = $dinosaur;
    }

    public function isSecurityActive(): bool
    {
        /** @var Security $security */
        foreach ($this->getSecurities() as $security) {
            if ($security->getIsActive()) {
                return true;
            }
        }

        return false;
    }

    private function canAddDinosaur(Dinosaur $dinosaur)
    {
        return count($this->getDinosaurs()) == 0 || $this->getDinosaurs()->first()->isCarnivorous() == $dinosaur->isCarnivorous();
    }

    /**
     * @param Security $security
     */
    public function addSecurity(Security $security)
    {
        $this->securities[] = $security;
    }

}
