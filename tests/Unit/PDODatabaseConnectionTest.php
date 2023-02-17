<?php

namespace Tests\Unit;

use App\Contracts\DatabaseConnectionInterface;
use App\Database\PDODatabaseConnection;
use App\Exceptions\ConfigNotValidException;
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

    public function testConnectMethosdShouldReturnValiadInstance()
    {
        $config = $this->getConfig();
        $pdoConnection = new PDODatabaseConnection($config);

        $pdoHandler = $pdoConnection->connect();
        $this->assertInstanceOf(PDODatabaseConnection::class, $pdoHandler);
        return $pdoHandler;
    }

    /**
     * @depends testConnectMethosdShouldReturnValiadInstance
     */
    public function testConnectMethodShouldBeConnectToDatabase($pdoHandler)
    {
        $this->assertInstanceOf(PDO::class, $pdoHandler->getConnection());
    }

    public function testItThrowExceptionIfConfigIsInvalid()
    {
        $this->expectException(DatabaseConnectionException::class);
        $config = $this->getConfig();
        $config['database'] = 'dummy';
        $pdoConnection = new PDODatabaseConnection($config);
        $pdoConnection->connect();
    }

    public function testReceivedConfigHaveRequiredKey()
    {
        $this->expectException(ConfigNotValidException::class);
        $config = $this->getConfig();
        unset($config['db_user']);

        $pdoConnection = new PDODatabaseConnection($config);
        $pdoConnection->connect();
    }

    private function getConfig()
    {
        return Config::get('database', 'pdo_testing');
    }
}
