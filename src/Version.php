<?php

declare(strict_types=1);

/*
 * This file is part of kodekeep/version.
 *
 * (c) KodeKeep <hello@kodekeep.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KodeKeep\Version;

use PharIo\Version\Version as Phar;

final class Version
{
    private Phar $version;

    private function __construct(string $version)
    {
        $this->version = new Phar($version);
    }

    public static function parse(string $version): self
    {
        return new static($version);
    }

    public function getMajor(): int
    {
        return (int) $this->version->getMajor()->getValue();
    }

    public function getMinor(): int
    {
        return (int) $this->version->getMinor()->getValue();
    }

    public function getPatch(): int
    {
        return (int) $this->version->getPatch()->getValue();
    }

    public function getStability(): ?string
    {
        if (! $this->isPreRelease()) {
            return null;
        }

        return $this->version->getPreReleaseSuffix()->getValue();
    }

    public function isPreRelease(): bool
    {
        return ! empty($this->version->getPreReleaseSuffix());
    }

    public static function diff(string $old, string $new): ?string
    {
        if (static::parse($new)->getMajor() > static::parse($old)->getMajor()) {
            return 'major';
        }

        if (static::parse($new)->getMinor() > static::parse($old)->getMinor()) {
            return 'minor';
        }

        if (static::parse($new)->getPatch() > static::parse($old)->getPatch()) {
            return 'patch';
        }

        return null;
    }
}
