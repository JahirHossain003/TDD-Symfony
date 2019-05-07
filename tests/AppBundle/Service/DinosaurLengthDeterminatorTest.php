<?php


namespace Tests\AppBundle\Service;


use AppBundle\Entity\Dinosaur;
use AppBundle\Service\DinosaurLengthDeterminator;
use PHPUnit\Framework\TestCase;

class DinosaurLengthDeterminatorTest extends TestCase
{
    /**
     * @dataProvider lengthDeterminatorTest
     */
    public function testItReturnsCorrectLengthRange(string $spec, $expectedMinLength, $expectedMaxLength)
    {
        $determinator = new DinosaurLengthDeterminator();
        $length = $determinator->getLengthFromSpecification($spec);

        $this->assertGreaterThanOrEqual($expectedMinLength, $length);
        $this->assertLessThanOrEqual($expectedMaxLength, $length);
    }

    public function lengthDeterminatorTest()
    {
        return [
            // specification min max
            ['large carnivorous dinosaur',Dinosaur::LARGE,Dinosaur::HUGE],
            "Default Dinosaur" => ['Hack dinosour park',1,Dinosaur::LARGE],
            ['large vegiterian dinosaur',Dinosaur::LARGE,Dinosaur::HUGE],
            ['Huge Dinosaur',Dinosaur::HUGE,100],
            ['Huge Dino',Dinosaur::HUGE,100],
            ['Huge',Dinosaur::HUGE,100],
            ['OMG',Dinosaur::HUGE,100]
        ];
    }
}
