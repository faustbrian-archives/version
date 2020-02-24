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

namespace KodeKeep\Version\Tests\Unit;

use KodeKeep\Version\Version;
use PHPUnit\Framework\TestCase;

/**
 * @covers \KodeKeep\Version\Version
 */
class VersionTest extends TestCase
{
    /** @test */
    public function it_cat_determine_the_major(): void
    {
        $this->assertSame(1, Version::parse('1.2.3-alpha.1')->getMajor());
    }

    /** @test */
    public function it_cat_determine_the_minor(): void
    {
        $this->assertSame(2, Version::parse('1.2.3-alpha.1')->getMinor());
    }

    /** @test */
    public function it_cat_determine_the_patch(): void
    {
        $this->assertSame(3, Version::parse('1.2.3-alpha.1')->getPatch());
    }

    /** @test */
    public function it_cat_determine_the_stability(): void
    {
        $this->assertNull(Version::parse('1.2.3')->getStability());
        $this->assertSame('alpha', Version::parse('1.2.3-alpha.1')->getStability());
    }

    /** @test */
    public function it_cat_determine_if_a_version_is_a_pre_release(): void
    {
        $this->assertFalse(Version::parse('1.2.3')->isPreRelease());
        $this->assertTrue(Version::parse('1.2.3-alpha.1')->isPreRelease());
    }

    /** @test */
    public function it_cat_determine_the_type_of_difference_between_two_versions(): void
    {
        $this->assertNull(Version::diff('1.0.0', '1.0.0'));
        $this->assertSame('major', Version::diff('1.0.0', '2.0.0'));
        $this->assertSame('minor', Version::diff('1.0.0', '1.1.0'));
        $this->assertSame('patch', Version::diff('1.0.0', '1.0.1'));
    }
}
