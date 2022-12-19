<?php declare(strict_types=1);

namespace OpenDaje\WorkermanRuntime;

use Workerman\Worker;

class ServerFactory
{
    private const DEFAULT_OPTIONS = [
        'host' => '0.0.0.0',
        'port' => 8000,
        'process' => 8,
        'name' => 'WorkermanRuntime',
    ];

    /**
     * @var array
     */
    private $options;

    public function __construct(array $options = [])
    {
        $options['host'] = $options['host'] ?? $_SERVER['WORKERMAN_HOST'] ?? $_ENV['WORKERMAN_HOST'] ?? self::DEFAULT_OPTIONS['host'];
        $options['port'] = $options['port'] ?? $_SERVER['WORKERMAN_PORT'] ?? $_ENV['WORKERMAN_PORT'] ?? self::DEFAULT_OPTIONS['port'];
        $options['process'] = $options['process'] ?? $_SERVER['WORKERMAN_PROCESS'] ?? $_ENV['WORKERMAN_PROCESS'] ?? self::DEFAULT_OPTIONS['process'];
        $options['name'] = $options['name'] ?? $_SERVER['WORKERMAN_NAME'] ?? $_ENV['WORKERMAN_NAME'] ?? self::DEFAULT_OPTIONS['name'];

        $this->options = array_replace_recursive(self::DEFAULT_OPTIONS, $options);
    }

    public static function getDefaultOptions(): array
    {
        return self::DEFAULT_OPTIONS;
    }

    public function createServer(callable $requestHandler): Worker
    {
        $worker = new Worker(sprintf("http://%s:%s", $this->options['host'], $this->options['port']));
        $worker->count = $this->options['process'];
        $worker->name = $this->options['name'];
        //        $worker->onMessage = static function ($connection, $request) {
        //            $connection->send('hello word by \\OpenDaje\\Workman\\Runtime');
        //        };
        $worker->onMessage = static function ($connection, $request) use ($requestHandler) {
            $connection->send(
                ($requestHandler)()
            );
        };
        Worker::runAll();
        return $worker;
    }

    /**
     * Use only for PHPUnit test
     */
    public function createServerForTest(callable $requestHandler): Worker
    {
        $worker = new Worker(sprintf("http://%s:%s", $this->options['host'], $this->options['port']));
        $worker->count = $this->options['process'];
        $worker->onMessage = static function ($connection, $request) use ($requestHandler) {
            $connection->send(
                ($requestHandler)()
            );
        };

        /** disabled for test */
        //Worker::runAll();
        return $worker;
    }

    public function getOptions(): array
    {
        return $this->options;
    }
}
