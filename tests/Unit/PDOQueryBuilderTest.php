<?php

namespace Tests\Unit;

use App\Database\PDODatabaseConnection;
use App\Database\PDOQueryBuilder;
use App\Helpers\Config;
use PHPUnit\Framework\TestCase;

class PDOQueryBuilderTest extends TestCase
{
    public function testItCountCreateData()
    {

        $pdoConnection = new PDODatabaseConnection($this->getConfig());
        $queryBuilder = new PDOQueryBuilder($pdoConnection->connect());

        $data = [
            'name' => 'First Bug Report',
            'link' => 'http://link.com',
            'user' => 'Navid Vakili',
            'email' => 'vakili.jd@gmail.com'
        ];

        $result = $queryBuilder->table('bugs')->create($data);

        $this->assertIsInt($result);
        $this->assertGreaterThan(0, $result);
    }

    private function getConfig()
    {
        return Config::get('database', 'pdo_testing');
    }
}
