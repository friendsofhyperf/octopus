<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */
namespace Hyperf\Octopus\Client;

use Hyperf\Octopus\Client;
use Hyperf\Octopus\Event\EventInterface;

class WebSocketClient extends Client
{
    public function handle(EventInterface $event): bool
    {
        return true;
    }
}
