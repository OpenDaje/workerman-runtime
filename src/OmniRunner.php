<?php declare(strict_types=1);

namespace OpenDaje\WorkermanRuntime;

use Symfony\Component\Runtime\RunnerInterface;

/**
 * A simple runner that will run a callable.
 *
 * @author Zerai Teclai <teclaizerai@gmail.com>
 */
class OmniRunner implements RunnerInterface
{
    private ServerFactory$serverFactory;

    /**
     * @var @mixed
     */
    private $application;

    public function __construct(ServerFactory $serverFactory, $application)
    {
        $this->serverFactory = $serverFactory;
        $this->application = $application;
    }

    public function run(): int
    {
        $this->serverFactory->createServer($this->application);

        return 0;
    }
}
