<?php

declare(strict_types=1);

namespace Gamebetr\Provable\Tests;

use Exception;
use Gamebetr\Provable\Provable;
use PHPUnit\Framework\TestCase;

/**
 * Class ProvableTest.
 *
 * @coversDefaultClass \Gamebetr\Provable\Provable
 */
class ProvableTest extends TestCase
{
    /**
     * @covers ::getClientSeed
     */
    public function testGetClientSeed(): void
    {
        $this->assertEquals('abc123', (new Provable('abc123'))->getClientSeed());
    }

    /**
     * @covers ::getHashedServerSeed
     *
     * @depends testGetServerSeed
     */
    public function testGetHashedServerSeed(): void
    {
        $this->assertEquals('8f61ad5cfa0c471c8cbf810ea285cb1e5f9c2c5e5e5e4f58a3229667703e1587', (new Provable('abc123', 'def456'))->getHashedServerSeed());
    }

    /**
     * @covers ::getMax
     */
    public function testGetMax(): void
    {
        $this->assertEquals(20, (new Provable('abc123', null, 0, 20))->getMax());
    }

    /**
     * @covers ::getMin
     */
    public function testGetMin(): void
    {
        $this->assertEquals(5, (new Provable('abc123', null, 5, 20))->getMin());
    }

    /**
     * @covers ::getServerSeed
     */
    public function testGetServerSeed(): void
    {
        $this->assertEquals('def456', (new Provable('abc123', 'def456'))->getServerSeed());
    }

    /**
     * @covers ::getType
     */
    public function testGetType(): void
    {
        $this->assertEquals('number', (new Provable('abc123', null, 0, 10, 'number'))->getType());
        $this->assertEquals('shuffle', (new Provable('abc123', null, 0, 10, 'shuffle'))->getType());
    }

    /**
     * @covers ::number
     * @covers ::generateSeedInteger
     */
    public function testNumber(): void
    {
        $expected = [6, 9, 2, 8, 2];
        $provable = new Provable('abc123', 'def456', 0, 10, 'number');
        foreach ($expected as $expected_number) {
            $this->assertEquals($expected_number, $provable->number());
        }
    }

    /**
     * @covers ::results
     *
     * @depends testNumber
     * @depends testShuffle
     */
    public function testResults(): void
    {
        $provable = new Provable('abc123', null, 0, 10, 'number');
        $this->assertIsInt($provable->results());

        $provable = new Provable('abc123', null, 0, 10, 'shuffle');
        $this->assertIsArray($provable->results());
    }

    /**
     * @covers ::setClientSeed
     * @covers ::generateRandomSeed
     */
    public function testSetClientSeed(): void
    {
        $provable = new Provable('abc123');
        $this->assertEquals('abc123', $provable->getClientSeed());
        $provable->setClientSeed('def456');
        $this->assertEquals('def456', $provable->getClientSeed());

        $provable->setClientSeed();
        $this->assertNotNull($provable->getClientSeed());
        $this->assertNotEquals('def456', $provable->getClientSeed());
    }

    /**
     * @covers ::setMax
     */
    public function testSetMax(): void
    {
        $provable = new Provable('abc123', null, 0, 10);
        $this->assertEquals(10, $provable->getMax());
        $provable->setMax(5);
        $this->assertEquals(5, $provable->getMax());
    }

    /**
     * @covers ::setMin
     */
    public function testSetMin(): void
    {
        $provable = new Provable('abc123', null, 0);
        $this->assertEquals(0, $provable->getMin());
        $provable->setMin(5);
        $this->assertEquals(5, $provable->getMin());
    }

    /**
     * @covers ::setServerSeed
     * @covers ::generateRandomSeed
     */
    public function testSetServerSeed(): void
    {
        $provable = new Provable('abc123');
        $this->assertNotNull($provable->getServerSeed());
        $provable->setServerSeed('def456');
        $this->assertEquals('def456', $provable->getServerSeed());
    }

    /**
     * @covers ::setType
     */
    public function testSetType(): void
    {
        $provable = new Provable('abc123', null, 0, 10, 'number');
        $this->assertEquals('number', $provable->getType());
        $provable->setType('shuffle');
        $this->assertEquals('shuffle', $provable->getType());
    }

    /**
     * @covers ::shuffle
     * @covers ::generateSeedInteger
     */
    public function testShuffle(): void
    {
        $expected = [1, 3, 4, 0, 2, 5];
        $provable = new Provable('abc123', 'def456', 0, 5, 'shuffle');
        $this->assertEquals($expected, $provable->shuffle());
    }

    /**
     * @covers ::__construct
     */
    public function test__construct(): void
    {
        $provable = new Provable('abc123', 'def456', 1, 10, 'number');
        $this->assertEquals('abc123', $provable->getClientSeed());
        $this->assertEquals('def456', $provable->getServerSeed());
        $this->assertEquals(1, $provable->getMin());
        $this->assertEquals(10, $provable->getMax());
        $this->assertEquals('number', $provable->getType());
    }

    /**
     * @covers ::getServerSeed
     * @covers ::getHashedServerSeed
     *
     * @depends testGetHashedServerSeed
     * @depends testGetServerSeed
     */
    public function test_empty_server_seed_is_random(): void
    {
        $provable_1 = new Provable('abc123');
        $provable_2 = new Provable('abc123');

        $this->assertNotEquals($provable_1->getHashedServerSeed(), $provable_2->getHashedServerSeed());
        $this->assertNotEquals($provable_1->getServerSeed(), $provable_2->getServerSeed());
    }

    /**
     * @covers ::setType
     *
     * @depends testSetType
     */
    public function test_invalid_type_throws_exception(): void
    {
        $this->expectException(Exception::class);
        new Provable('abc123', null, 0, 10, 'RandomClass'.time());
    }

    /**
     * @covers ::number
     *
     * @depends testNumber
     */
    public function test_number_generation_is_repeatable(): void
    {
        $rolls = [];

        $provable = new Provable('abc123', 'def456', 0, 10, 'number');
        for ($i = 0; $i < 10; $i++) {
            $rolls[0][] = $provable->results();
        }

        sleep(3);

        $provable = new Provable('abc123', 'def456', 0, 10, 'number');
        for ($i = 0; $i < 10; $i++) {
            $rolls[1][] = $provable->results();
        }

        $this->assertEquals($rolls[0], $rolls[1]);
    }

    /**
     * @covers ::shuffle
     */
    public function test_shuffle_range_is_min_max(): void
    {
        $provable = new Provable('abc123', 'def456', 1, 5, 'shuffle');
        $this->assertCount(5, $provable->shuffle());

        $this->assertCount(10, $provable->shuffle(1, 10));
    }

    /**
     * @covers ::number
     * @covers ::shuffle
     * @covers ::results
     */
    public function test_provable_is_resettable(): void
    {
        $rolls = [];
        $provable = new Provable('abc123', 'def456', 1, 10, 'number');
        for ($i = 0; $i < 10; $i++) {
            $rolls[0][] = $provable->number();
        }
        sleep(3);
        $provable->reset();
        for ($i = 0; $i < 10; $i++) {
            $rolls[1][] = $provable->number();
        }
        $this->assertEquals($rolls[0], $rolls[1]);
        $rolls = [];
        $provable = new Provable('abc123', 'def456', 1, 10, 'shuffle');
        for ($i = 0; $i < 10; $i++) {
            $rolls[0][] = $provable->shuffle();
        }
        sleep(3);
        $provable->reset();
        for ($i = 0; $i < 10; $i++) {
            $rolls[1][] = $provable->shuffle();
        }
        $this->assertEquals($rolls[0], $rolls[1]);
        $rolls = [];
        $provable = new Provable('abc123', 'def456', 1, 10, 'number');
        for ($i = 0; $i < 10; $i++) {
            $rolls[0][] = $provable->results();
        }
        sleep(3);
        $provable->reset();
        for ($i = 0; $i < 10; $i++) {
            $rolls[1][] = $provable->results();
        }
        $this->assertEquals($rolls[0], $rolls[1]);
    }
}
