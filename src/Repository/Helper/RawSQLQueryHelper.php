<?php

declare(strict_types=1);

namespace App\Repository\Helper;

use Doctrine\ORM\EntityManagerInterface;

/**
 * Class RawSQLQueryHelper
 * @package App\Repository\Helper
 */
trait RawSQLQueryHelper
{
    /**
     * @param EntityManagerInterface $em
     * @param string $sql
     * @param array $options
     * @return \Doctrine\DBAL\Driver\Statement
     * @throws \Doctrine\DBAL\DBALException
     */
    public static function createCustomStatement(EntityManagerInterface $em, string $sql, array $options = [])
    {
        $connection = $em->getConnection();
        $stmt = $connection->prepare($sql);
        $stmt->execute($options);

        return $stmt;
    }
}