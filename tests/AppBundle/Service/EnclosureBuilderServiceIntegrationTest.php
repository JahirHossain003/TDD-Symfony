<?php


namespace Tests\AppBundle\Service;


use AppBundle\Entity\Dinosaur;
use AppBundle\Entity\Enclosure;
use AppBundle\Entity\Security;
use AppBundle\Service\EnclosureBuilderService;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class EnclosureBuilderServiceIntegrationTest extends KernelTestCase
{
     public function setUp()
      {
        self::bootKernel();
        $this->truncateEntities([
            Enclosure::class,
            Security::class,
            Dinosaur::class,
        ]);
      }

      public function testItBuildsEnclosureWithDefaultSpecifications()
      {

          /** @var EnclosureBuilderService $enclosureBuilderService */
          $enclosureBuilderService = self::$kernel->getContainer()->get('test.'.EnclosureBuilderService::class);

          $enclosureBuilderService->buildEnclosure();

          /** @var EntityManager $em */
          $em = self::$kernel->getContainer()->get('doctrine')->getManager();

          $count = (int) $em->getRepository(Security::class)
              ->createQueryBuilder('s')
              ->select('COUNT(s.id)')
              ->getQuery()
              ->getSingleScalarResult();

          $this->assertSame(1, $count, 'Amount of security systems is not the same');

          $count = (int) $em->getRepository(Dinosaur::class)
              ->createQueryBuilder('d')
              ->select('COUNT(d.id)')
              ->getQuery()
              ->getSingleScalarResult();

          $this->assertSame(3, $count, 'Amount of Dinosaur is not the same');
      }

    private function truncateEntities(array $entities)
    {
        $connection = $this->getEntityManager()->getConnection();
        $databasePlatform = $connection->getDatabasePlatform();
        if ($databasePlatform->supportsForeignKeyConstraints()) {
            $connection->query('SET FOREIGN_KEY_CHECKS=0');
        }
        foreach ($entities as $entity) {
            $query = $databasePlatform->getTruncateTableSQL(
                $this->getEntityManager()->getClassMetadata($entity)->getTableName()
            );
            $connection->executeUpdate($query);
        }
        if ($databasePlatform->supportsForeignKeyConstraints()) {
            $connection->query('SET FOREIGN_KEY_CHECKS=1');
        }
    }

    /**
     * @return EntityManager
     */
    private function getEntityManager()
    {
        return self::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }
}
