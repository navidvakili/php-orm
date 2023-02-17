<?php

namespace Tests\Unit;

use App\Contracts\DatabaseConnectionInterface;
use App\Database\PDODatabaseConnection;
use App\Exceptions\DatabaseConnectionException;
use App\Helpers\Config;
use PDO;
use PHPUnit\Framework\TestCase;

class PDODataBaseConnectionTest extends TestCase
{
    public function testPDPDatabaseConnectionImplementsDatabaseConnectionInterface()
    {
        $config = $this->getConfig();
        $pdoConnection = new PDODatabaseConnection($config);

        $this->assertInstanceOf(DatabaseConnectionInterface::class, $pdoConnection);
    }

    public function testConnectMethodShouldBeConnectToDatabase()
    {
        $config = $this->getConfig();
        $pdoConnection = new PDODatabaseConnection($config);

        $pdoConnection->connect();
        $this->assertInstanceOf(PDO::class, $pdoConnection->getConnection());
    }

    public function testItThrowExceptionIfConfigIsInvalid()
    {
        $this->expectException(DatabaseConnectionException::class);
        $config = $this->getConfig();
        $config['database'] = 'dummy';
        $pdoConnection = new PDODatabaseConnection($config);
        $pdoConnection->connect();
    }

    private function getConfig()
    {
        return Config::get('database', 'pdo_testing');
    }
}
