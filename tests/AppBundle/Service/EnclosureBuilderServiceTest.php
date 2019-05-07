<?php


namespace Tests\AppBundle\Service;


use AppBundle\Entity\Enclosure;
use AppBundle\Factory\DinosaurFactory;
use AppBundle\Service\EnclosureBuilderService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\TestCase;

class EnclosureBuilderServiceTest extends TestCase
{
    public function testItBuildsAndPersistsEnclosure()
    {
        $db = $this->createMock(EntityManagerInterface::class);
        $dinoFactory = $this->createMock(DinosaurFactory::class);
        $dinoFactory->expects($this->exactly(2))->method('growFromSpecification')->with($this->isType('string'));

        $db->expects($this->once())->method('persist')->with($this->isInstanceOf(Enclosure::class));
        $db->expects($this->atLeastOnce())->method('flush');

        $builder = new EnclosureBuilderService($db,$dinoFactory);
        $enclosure = $builder->buildEnclosure(1,2);
        $this->assertCount(1,$enclosure->getSecurities());
        $this->assertCount(2,$enclosure->getDinosaurs());
    }
}
