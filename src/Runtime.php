<?php declare(strict_types=1);

namespace OpenDaje\WorkermanRuntime;

use Symfony\Component\Runtime\RunnerInterface;
use Symfony\Component\Runtime\SymfonyRuntime;

/**
 * A runtime for workerman.
 *
 * @author Zerai Teclai <teclaizerai@gmail.com>
 * @see https://github.com/walkor/workerman-manual/blob/master/english/SUMMARY.md
 */
class Runtime extends SymfonyRuntime
{
    private ?ServerFactory $serverFactory;

    public function __construct(array $options, ?ServerFactory $serverFactory = null)
    {
        $this->serverFactory = $serverFactory ?? new ServerFactory($options);
        parent::__construct($this->serverFactory->getOptions());
    }

    public function getRunner(?object $application): RunnerInterface
    {
        if (! \is_callable($application)) {
            return new OmniRunner($this->serverFactory, $application);
        }
        if (\is_callable($application)) {
            return new CallableRunner($this->serverFactory, $application);
        }
        return parent::getRunner($application);
    }
}
