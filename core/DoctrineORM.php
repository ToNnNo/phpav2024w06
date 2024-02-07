<?php

namespace Core;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\UnderscoreNamingStrategy;
use Doctrine\ORM\ORMSetup;

class DoctrineORM
{
    private EntityManagerInterface $entityManager;
    private Connection $connection;

    public function __construct()
    {
        $config = ORMSetup::createAttributeMetadataConfiguration(
            [dirname(__DIR__) . "/src/Entity"],
            true
        );

        $config->setNamingStrategy(new UnderscoreNamingStrategy(CASE_LOWER));

        $this->connection = DriverManager::getConnection([
            'driver' => 'pdo_mysql',
            'dbname' => 'php2024w06',
            'user' => 'root',
            'password' => 'root',
            'host' => 'localhost:3306',
            // 'port' => 3306,
            'charset' => 'utf8mb4'
        ], $config);

        $this->entityManager = new EntityManager($this->connection, $config);
    }

    public function getConnection(): Connection
    {
        return $this->connection;
    }

    public function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }

    public function getRepository(string $entityName): EntityRepository
    {
        return $this->entityManager->getRepository($entityName);
    }
}
