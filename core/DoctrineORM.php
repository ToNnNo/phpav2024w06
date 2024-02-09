<?php

namespace Core;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Logging\Middleware;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\UnderscoreNamingStrategy;
use Doctrine\ORM\ORMSetup;
use Psr\Log\AbstractLogger;

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

        $config->setMiddlewares([new Middleware(new class extends AbstractLogger {
            public function log($level, $message, array $context = []): void
            {
                $path = dirname(__DIR__) . "/var/log/doctrine.log";

                if( array_key_exists('sql', $context) ) {

                    $content = sprintf("[%s] %s: %s;",
                        (new \DateTime())->format("c"),
                        $level,
                        $context['sql']
                    );

                    if( array_key_exists('params', $context)) {
                        $content .= sprintf(" (Paramètres: %s)", json_encode(array_values($context['params'])));
                    }

                    $content .= "\r\n";
                    file_put_contents($path, $content, FILE_APPEND);
                }
            }
        })]);

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
