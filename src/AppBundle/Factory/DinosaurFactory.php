<?php


namespace AppBundle\Factory;


use AppBundle\Entity\Dinosaur;

class DinosaurFactory
{
    /**
     * This function returns a Velociraptor Dinosaur
     * @param int $length
     * @return Dinosaur
     */
    public function growVelociraptor(int $length) : Dinosaur
    {
         return $this->createDinosaur('Velociraptor', true, $length);
    }

    private function createDinosaur(string $genus, bool $isCarnivorous, $length) : Dinosaur
    {
        $dinosaur = new Dinosaur($genus, $isCarnivorous);

        $dinosaur->setLength($length);

        return $dinosaur;
    }

}
