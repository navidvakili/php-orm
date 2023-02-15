<?php

namespace Tests\Unit;

use App\Exceptions\ConfigFileNotFoundExcpetion;
use App\Helpers\Config;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    public function testGetFileContentReturnsArray()
    {
        $config = Config::getFileContents('database');
        $this->assertIsArray($config);
    }

    public function testItThrowsExceptionIfFileNotFound()
    {
        $this->expectException(ConfigFileNotFoundExcpetion::class);
        $config = Config::getFileContents('dummy');
    }

    public function testGetMethodReturnValidaData()
    {
        $config = Config::get('database', 'pdo');

        $expectedData = [
            'driver' => 'mysql',
            'host' => '127.0.0.1',
            'database' => 'bug_tracker',
            'db_user' => 'root',
            'db_password' => '123456'
        ];

        $this->assertEquals($config, $expectedData);
    }
}
