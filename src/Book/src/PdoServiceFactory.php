<?php
namespace Book;

use Interop\Container\ContainerInterface;
use PDOException;

class PdoServiceFactory
{
    public function __invoke(ContainerInterface $container): PdoService
    {
        $db = $container->get('config')['database'] ?? null;
        if (null === $db) {
            throw new Exception\InvalidConfigException(
                'The database configuration is missing'
            );
        }
        try {
            return new PdoService($db['dsn'], $db['user'], $db['password']);
        } catch (PDOException $e) {
            throw new Exception\RuntimeException(
                'Error during the database connection'
            );
        }
    }
}
