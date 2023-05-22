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
    public const KEY_PREFIX = 'octopus:';

    public function __construct(protected Redis $redis, protected int|string $uid, protected string $nodeId, protected int $fd)
    {
    }

    public function getUid(): int|string
    {
        return $this->uid;
    }

    public function getNodeId(): string
    {
        return $this->nodeId;
    }

    public function getFd(): int
    {
        return $this->fd;
    }

    public function save(): void
    {
        $key = self::KEY_PREFIX . $this->uid;

        $this->redis->set($key, Json::encode($this->toArray()), 8640000);
    }

    public function toArray(): array
    {
        return [
            'uid' => $this->uid,
            'node_id' => $this->nodeId,
            'fd' => $this->fd,
        ];
    }

    public static function from(Redis $redis, int|string $uid): static
    {
        $key = self::KEY_PREFIX . $uid;

        $data = $redis->get($key);

        return new static($redis, $data['uid'], $data['node_id'], $data['fd']);
    }
}
