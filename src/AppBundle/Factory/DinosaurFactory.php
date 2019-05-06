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

    public function growFromSpecification(string $spec) : Dinosaur
    {
        // Default Value
        $genus = 'InG-'.rand(1,9999);
        $isCarnivorous = false;
        $length = $this->getLengthFromSpecification($spec);

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

    private function getLengthFromSpecification(string $specification): int
    {
        $availableLengths = [
            'huge' => ['min' => Dinosaur::HUGE, 'max' => 100],
            'omg' => ['min' => Dinosaur::HUGE, 'max' => 100],
            'large' => ['min' => Dinosaur::LARGE + 1, 'max' => Dinosaur::HUGE - 1],
        ];
        $minLength = 1;
        $maxLength = Dinosaur::LARGE - 1;

        foreach (explode(' ', $specification) as $keyword) {
            $keyword = strtolower($keyword);

            if (array_key_exists($keyword, $availableLengths)) {
                $minLength = $availableLengths[$keyword]['min'];
                $maxLength = $availableLengths[$keyword]['max'];

                break;
            }
        }

        return random_int($minLength, $maxLength);
    }

}
