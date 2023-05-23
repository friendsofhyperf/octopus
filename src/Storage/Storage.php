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
namespace Hyperf\Octopus\Storage;

use Hyperf\Octopus\Exception\InvalidArgumentException;
use Hyperf\Redis\RedisFactory;
use Psr\Container\ContainerInterface;

use function Hyperf\Config\config;

class Storage
{
    protected StorageInterface $storage;

    public function __construct(private ContainerInterface $container)
    {
        $config = config('octopus.storage');

        $driver = $config['driver'];
        switch ($driver) {
            case 'redis':
                $pool = $config['drivers']['redis']['pool'];
                $redis = $this->container->get(RedisFactory::class)->get($pool);
                $this->storage = new RedisStorage(
                    $redis,
                    $config['drivers']['redis']['key_prefix'] ?? '{octopus}:',
                    $config['drivers']['redis']['ttl'] ?? 864000,
                );
                break;
            default:
                throw new InvalidArgumentException('The driver of storage is invalid.');
        }
    }

    public function from(int|string $uid): StorageInterface
    {
        $config = config('octopus.storage');

        $driver = $config['driver'];
        switch ($driver) {
            case 'redis':
                $pool = $config['drivers']['redis']['pool'];
                $redis = $this->container->get(RedisFactory::class)->get($pool);
                return RedisStorage::from($redis, $uid);
            default:
                throw new InvalidArgumentException('The driver of storage is invalid.');
        }
    }
}
