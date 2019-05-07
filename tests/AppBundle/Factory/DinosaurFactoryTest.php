<?php


namespace Tests\AppBundle\Factory;


use AppBundle\Entity\Dinosaur;
use AppBundle\Factory\DinosaurFactory;
use AppBundle\Service\DinosaurLengthDeterminator;
use PHPUnit\Framework\TestCase;

class DinosaurFactoryTest extends TestCase
{
    /** @var DinosaurFactory $factory */
    protected $factory;

    public function setUp()
    {
        $lengthDetarminator = $this->createMock(DinosaurLengthDeterminator::class);
        $this->factory = new DinosaurFactory($lengthDetarminator);
    }

    public function testItGrowsAVelociraptor()
    {
        $dinosaur = $this->factory->growVelociraptor(5);

        $this->assertInstanceOf(Dinosaur::class, $dinosaur);
        $this->assertInternalType('string', $dinosaur->getGenus());
        $this->assertSame('Velociraptor', $dinosaur->getGenus());
        $this->assertSame(5, $dinosaur->getLength());

    }

    public function testItGrowsATriceratops()
    {
        $this->markTestIncomplete('Waiting for confirmation from GenLab');
    }

    public function testItGrowsABabyVelociraptors()
    {
        if (!class_exists('Nanny')) {
            $this->markTestSkipped('There is nobody to look for the baby');
        }

        $dinosaur = $this->factory->growVelociraptor(1);

        $this->assertSame(1, $dinosaur->getLength());
    }

    /**
     * @dataProvider dinosaurSpecificationTest
     */
    public function testItGrowsADinosourFromSpecification(string $spec, bool
    $isExpectedCarnivorous)
    {
        $dinosaur = $this->factory->growFromSpecification($spec);

        $this->assertSame($isExpectedCarnivorous, $dinosaur->isCarnivorous());
    }

    public function dinosaurSpecificationTest()
    {
        return [
          // specification, is large, is carnivorous
            ['large carnivorous dinosaur',true],
            "Default Dinosaur" => ['Hack dinosour park',false],
            ['large vegiterian dinosaur',false],
        ];
    }

}
