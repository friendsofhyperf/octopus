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
namespace Hyperf\Octopus\Event;

use Hyperf\Contract\Arrayable;
use Hyperf\Contract\JsonDeSerializable;
use JsonSerializable;

class Event implements EventInterface, JsonSerializable, JsonDeSerializable, Arrayable
{
    public function __construct(public string $nodeId, public array $payload, public array $fds = [])
    {
    }

    public function toArray(): array
    {
        return [
            'node_id' => $this->nodeId,
            'payload' => $this->payload,
            'fds' => $this->fds,
        ];
    }

    public static function jsonDeSerialize(mixed $data): static
    {
        try {
            return new Event(
                $data['node_id'],
                $data['payload'],
                $data['fds'],
            );
        } catch (\Throwable) {
            return new BrokenEvent($data);
        }
    }

    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }

    public function getNodeId(): string
    {
        return $this->nodeId;
    }

    public function getPayload(): array
    {
        return $this->payload;
    }

    public function getFds(): array
    {
        return $this->fds;
    }

    public function isSuccess(): bool
    {
        return true;
    }
}
