<?php


namespace Tests\AppBundle\Factory;


use AppBundle\Entity\Dinosaur;
use AppBundle\Factory\DinosaurFactory;
use PHPUnit\Framework\TestCase;

class DinosaurFactoryTest extends TestCase
{
    /** @var DinosaurFactory $factory */
    protected $factory;

    public function setUp()
    {
        $this->factory = new DinosaurFactory();
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
    public function testItGrowsADinosourFromSpecification(string $spec, bool $isExpectedLarge, bool
    $isExpectedCarnivorous)
    {
        $dinosaur = $this->factory->growFromSpecification($spec);

        if ($isExpectedLarge) {
            $this->assertGreaterThan(Dinosaur::LARGE, $dinosaur->getLength());
        } else {
            $this->assertLessThan(Dinosaur::LARGE, $dinosaur->getLength());
        }

        $this->assertSame($isExpectedCarnivorous, $dinosaur->isCarnivorous());
    }

    public function dinosaurSpecificationTest()
    {
        return [
          // specification, is large, is carnivorous
            ['large carnivorous dinosaur',true,true],
            "Default Dinosaur" => ['Hack dinosour park',false,false],
            ['large vegiterian dinosaur',true,false],
        ];
    }

    /**
     * @dataProvider hugeDinosaurSpecificationTest
     */
    public function testItGrowsHugeDinosaurFromSpecification(string $spec)
    {
        $dinosaur = $this->factory->growFromSpecification($spec);

        $this->assertGreaterThan(Dinosaur::HUGE, $dinosaur->getLength());
    }

    public function hugeDinosaurSpecificationTest()
    {
        return [
          ['Huge Dinosaur'],
          ['Huge Dino'],
          ['Huge'],
          ['OMG']
        ];
    }
}
