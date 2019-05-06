<?php


namespace Tests\AppBundle\Entity;


use AppBundle\Entity\Dinosaur;
use AppBundle\Entity\Enclosure;
use AppBundle\Exception\NotABuffetException;
use PHPUnit\Framework\TestCase;

class EnclosureTest extends TestCase
{

    public function testItHasNoDinosaurByDefault()
    {
        $enclosure = new Enclosure();

        $this->assertEmpty($enclosure->getDinosaurs());
    }

    public function testItAddsDinosaur()
    {
        $enclosure = new Enclosure();
        $enclosure->addDinosaur(new Dinosaur());
        $enclosure->addDinosaur(new Dinosaur());

        $this->assertCount(2,$enclosure->getDinosaurs());
    }

    public function testItTrowsExceptionWhenPuttingCarnivorousAndNonCarnivorousTogether()
    {
        $enclosure = new Enclosure();
        $enclosure->addDinosaur(new Dinosaur());
        $this->expectException(NotABuffetException::class);
        $enclosure->addDinosaur(new Dinosaur('Velociraptor',true));
    }
}
