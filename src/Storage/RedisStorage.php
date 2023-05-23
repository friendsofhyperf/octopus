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

use Hyperf\Codec\Json;
use Hyperf\Redis\Redis;

class RedisStorage implements StorageInterface
{
    public function __construct(protected Redis $redis, protected string $keyPrefix, protected int $ttl)
    {
    }

    public function save(Meta $meta): void
    {
        $key = $this->keyPrefix . $meta->uid;

        $this->redis->set($key, Json::encode($meta->toArray()), $this->ttl);
    }

    public function from(int|string $uid): Meta
    {
        $key = $this->keyPrefix . $uid;

        $data = Json::decode($this->redis->get($key));

        return Meta::jsonDeSerialize($data);
    }
}
