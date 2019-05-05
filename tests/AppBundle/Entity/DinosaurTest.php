<?php
namespace Tests\AppBundle\Entity;

use AppBundle\Entity\Dinosaur;
use PHPUnit\Framework\TestCase;

class DinosaurTest extends TestCase
{
    public function testIfEverythingWorksProperly()
    {
        $this->assertTrue(true);
    }

    public function testSettingLength()
    {
        $dinosaur = new Dinosaur();

        $this->assertSame(0, $dinosaur->getLength());

        $dinosaur->setLength(9);

        $this->assertSame(9, $dinosaur->getLength());
    }

    public function testDinosaurDidNotShrink()
    {
        $dinosaur = new Dinosaur();

        $dinosaur->setLength(15);

        $this->assertGreaterThan(12, $dinosaur->getLength(), "Did you put it to washing Machine ???");
    }
}
