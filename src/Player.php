<?php
declare(strict_types=1);

namespace Hockey;

final readonly class Player
{
    public function __construct(
        private int $number,
        private string $firstName,
        private string $lastName,
        private Position $position,
    ) {
    }

    public function getNumber(): int
    {
        return $this->number;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function getPosition(): Position
    {
        return $this->position;
    }
}