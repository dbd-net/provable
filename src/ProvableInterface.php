<?php

declare(strict_types=1);

namespace Gamebetr\Provable;

/**
 * Interface ProvableInterface.
 */
interface ProvableInterface
{
    /**
     * Get the client seed.
     *
     * @return string
     *   The current client seed.
     */
    public function getClientSeed(): string;

    /**
     * Get the hashed version of the server seed.
     *
     * @return string
     *   The hashed version of the current server seed.
     */
    public function getHashedServerSeed(): string;

    /**
     * Get the maximum allowed random number value.
     *
     * @return int
     */
    public function getMax(): int;

    /**
     * Get the minimum allowed random number value.
     *
     * @return int
     *   The minimum allowed random number value.
     */
    public function getMin(): int;

    /**
     * Get the server seed.
     *
     * @return string
     *   The current server seed.
     */
    public function getServerSeed(): string;

    /**
     * Get the provable type.
     *
     * @return string
     *   The provable type.
     */
    public function getType(): string;

    /**
     * Returns a random number within a range.
     *
     * @param int $minimumNumber
     *   The minimum allowed random number.
     * @param int $maximumNumber
     *   The maximum allowed random number.
     *
     * @return int
     *   The randomly generated number.
     */
    public function number(int $minimumNumber = null, int $maximumNumber = null): int;

    /**
     * Returns the results for the provable.
     *
     * @return int|array
     */
    public function results();

    /**
     * Set the client seed.
     *
     * @param string $clientSeed
     *   The client seed to set.
     *
     * @return \Gamebetr\Provable\ProvableInterface
     *   An instance of this object.
     */
    public function setClientSeed(string $clientSeed = null): self;

    /**
     * Set the maximum allowed random number value.
     *
     * @param int $max
     *   The maximum allowed random number value.
     *
     * @return \Gamebetr\Provable\ProvableInterface
     *   An instance of this object.
     */
    public function setMax(int $max): self;

    /**
     * Set the minimum allowed random number.
     *
     * @param int $min
     *   The minimum allowed random number.
     *
     * @return \Gamebetr\Provable\ProvableInterface
     *   An instance of this object.
     */
    public function setMin(int $min): self;

    /**
     * Set the server seed.
     *
     * @param string $serverSeed
     *   The server seed to set.
     *
     * @return \Gamebetr\Provable\ProvableInterface
     *   An instance of this object.
     */
    public function setServerSeed(string $serverSeed = null): self;

    /**
     * Set the provable type.
     *
     * @param string $type
     *   The provable type to set. One of number or shuffle.
     *
     * @return \Gamebetr\Provable\ProvableInterface
     *   An instance of this object.
     */
    public function setType(string $type): self;

    /**
     * Get a random shuffle of numbers within a range.
     *
     * Uses fisher yates shuffle (https://en.wikipedia.org/wiki/Fisher–Yates_shuffle)
     *
     * @param int $minimumNumber
     *   The minimum allowed random number.
     * @param int $maximumNumber
     *   The maximum allowed random number.
     *
     * @return int[]|array
     *   Returns a random shuffle of numbers within a range.
     */
    public function shuffle(int $minimumNumber = null, int $maximumNumber = null): array;

    /**
     * Reset the provable instance in order to start the results over from the top.
     *
     * @return \Gamebetr\Provable\ProvableInterface
     *   An instance of this object.
     */
    public function reset(): self;
}
