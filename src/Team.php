<?php
declare(strict_types=1);

namespace Hockey;

final class Team implements \Countable, \Iterator, \ArrayAccess
{
    private string $country;
    private array $players;
    private int $current = 0;

    public function __construct(string $country, ?array $players = [])
    {
        $this->country = $country;
        $this->players = $players;
    }

    public function getCountry() : string
    {
        return $this->country;
    }

    public function getPlayerByNumber(int $number) : Player
    {
        foreach ($this->players as $player) {
            if ($player->getNumber() === $number) {
                return $player;
            }
        }

        throw new \Exception('Игрока с таким номером в команде нет.');
    }

    public function current(): mixed
    {
        return $this->players[$this->key()];
    }

    public function next() 
    {
        return next($this->players);
    }

    public function key() : int
    {
        return key($this->players);
    }

    public function valid(): bool
    {
        return key($this->players) !== null;
    }

    public function rewind() : void
    {
        reset($this->players);
    }

    public function count(): int
    {
        return count($this->players);
    }

    public function offsetExists(mixed $offset): bool
    {
        foreach ($this->players as $player){
            if ($player->getNumber() === $offset) {
                return true;
            }
        }
        return false;
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->getPlayerByNumber((int)$offset);
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->players[] = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        foreach ($this->players as $key => $player){
            if ($player->getNumber() === $offset) {
                unset($this->players[$key]);
            }
        }
    }
}