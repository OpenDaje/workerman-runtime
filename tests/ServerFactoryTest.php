<?php declare(strict_types=1);

namespace OpenDaje\WorkermanRuntime\Tests;

use OpenDaje\WorkermanRuntime\ServerFactory;
use PHPUnit\Framework\TestCase;

class ServerFactoryTest extends TestCase
{
    private const EXPEXTED_DEFAULT_OPTIONS = [
        ['host', '0.0.0.0'],
        ['port', 8000],
        ['process', 8],
        ['name', 'WorkermanRuntime'],
    ];

    public function testCreateServerWithDefaultOptions(): void
    {
        $factory = new ServerFactory();

        $server = $factory->createServerForTest(static function (): void {
        });

        $defaults = ServerFactory::getDefaultOptions();

        self::assertSame(sprintf("http://%s:%s", $defaults['host'], $defaults['port']), $server->getSocketName());
    }

    public function testCreateServerWithGivenOptions(): void
    {
        $options = [
            'host' => '0.0.0.0',
            'port' => 8888,
        ];

        $factory = new ServerFactory($options);

        $server = $factory->createServerForTest(static function (): void {
        });

        self::assertSame('http://0.0.0.0:8888', $server->getSocketName());
    }

    /**
     * @param string $expectedOptionValue
     * @dataProvider defaultOptionDataprovider
     */
    public function testServerFactoryHasDefaultOptions(string $expectedOptionName, $expectedOptionValue): void
    {
        $serverFactory = new ServerFactory();

        self::assertArrayHasKey(
            $expectedOptionName,
            $serverFactory->getOptions(),
            'Error expected server factory default option named ' . $expectedOptionName
        );
        self::assertSame(
            $expectedOptionValue,
            $serverFactory->getOptions()[$expectedOptionName],
            'Error expected server factory default value ' . $expectedOptionValue
        );
    }

    public function defaultOptionDataprovider(): array
    {
        return self::EXPEXTED_DEFAULT_OPTIONS;
    }
}
