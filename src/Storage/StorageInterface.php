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

use Hyperf\Contract\Arrayable;

interface StorageInterface extends Arrayable
{
    public function getUid(): int|string;

    public function getNodeId(): string;

    public function getFd(): int;

    public function save(): void;
}
