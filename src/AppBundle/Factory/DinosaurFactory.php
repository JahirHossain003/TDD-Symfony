<?php


namespace AppBundle\Factory;


use AppBundle\Entity\Dinosaur;
use AppBundle\Service\DinosaurLengthDeterminator;

class DinosaurFactory
{
    /**
     * @var DinosaurLengthDeterminator
     */
    private $lengthDeterminator;

    public function __construct(DinosaurLengthDeterminator $lengthDeterminator)
    {
        $this->lengthDeterminator = $lengthDeterminator;
    }

    /**
     * This function returns a Velociraptor Dinosaur
     * @param int $length
     * @return Dinosaur
     */
    public function growVelociraptor(int $length) : Dinosaur
    {
         return $this->createDinosaur('Velociraptor', true, $length);
    }

    public function growFromSpecification(string $spec) : Dinosaur
    {
        // Default Value
        $genus = 'InG-'.rand(1,9999);
        $isCarnivorous = false;
        $length = $this->lengthDeterminator->getLengthFromSpecification($spec);

        if (strpos($spec,'carnivorous') !== false) {
            $isCarnivorous = true;
        }

        $dinosaur = $this->createDinosaur($genus,$isCarnivorous,$length);

        return $dinosaur;
    }


    private function createDinosaur(string $genus, bool $isCarnivorous, $length) : Dinosaur
    {
        $dinosaur = new Dinosaur($genus, $isCarnivorous);

        $dinosaur->setLength($length);

        return $dinosaur;
    }


}
