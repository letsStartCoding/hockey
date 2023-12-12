<?php
declare(strict_types=1);

namespace Tests;

use Hockey\Player;
use Hockey\Position;
use Hockey\Team;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Depends;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\TestCase;
use function PHPUnit\Framework\assertSame;
use function PHPUnit\Framework\assertTrue;

#[CoversClass(Team::class)]
#[TestDox('Тесты хоккейной команды')]
final class TeamTest extends TestCase
{
    #[TestDox('Тест получения страны команды')]
    public function testCountry(): void
    {
        $country = 'СССР';

        $team = new Team($country);

        assertSame($country, $team->getCountry());
    }

    #[TestDox('Тест получения игрока по его номеру')]
    #[Depends('testCountry')]
    public function testGetPlayerByNumber(): void
    {
        // arrange
        $players = [
            new Player(number: 17, firstName: 'Валерий', lastName: 'Харламов', position: Position::Forward),
            new Player(number: 15, firstName: 'Александр', lastName: 'Якушев', position: Position::Forward),
            new Player(number: 7, firstName: 'Геннадий', lastName: 'Цыганков', position: Position::Defender),
            new Player(number: 2, firstName: 'Александр', lastName: 'Гусев', position: Position::Defender),
            new Player(number: 20, firstName: 'Владислав', lastName: 'Третьяк', position: Position::Goalkeeper),
        ];
        $team = new Team('СССР', $players);

        // arrange
        $player = $team->getPlayerByNumber(7);

        assertSame($player, $players[2]);
    }

    #[TestDox('Тест количества игроков в команде')]
    #[Depends('testGetPlayerByNumber')]
    public function testCount(): void
    {
        $team = new Team('СССР', [
            new Player(number: 17, firstName: 'Валерий', lastName: 'Харламов', position: Position::Forward),
            new Player(number: 7, firstName: 'Геннадий', lastName: 'Цыганков', position: Position::Defender),
            new Player(number: 20, firstName: 'Владислав', lastName: 'Третьяк', position: Position::Goalkeeper),
        ]);

        assertSame(3, count($team));
    }

    #[TestDox('Тест возможности получать игроков в цикле')]
    #[Depends('testCount')]
    public function testCanForeach(): void
    {
        // arrange
        $players = [
            new Player(number: 17, firstName: 'Валерий', lastName: 'Харламов', position: Position::Forward),
            new Player(number: 7, firstName: 'Геннадий', lastName: 'Цыганков', position: Position::Defender),
            new Player(number: 20, firstName: 'Владислав', lastName: 'Третьяк', position: Position::Goalkeeper),
        ];
        $team = new Team('СССР', $players);

        // act
        $result = [];
        foreach ($team as $player) {
            $result[] = $player;
        }

        // assert
        assertSame($players, $result);
    }

    #[TestDox('Тест возможности добавлять игроков в команду')]
    #[Depends('testCanForeach')]
    public function testAddPlayer(): void
    {
        // arrange
        $team = new Team('СССР');

        // act
        $team[] = new Player(number: 17, firstName: 'Валерий', lastName: 'Харламов', position: Position::Forward);
        $team[] = new Player(number: 20, firstName: 'Владислав', lastName: 'Третьяк', position: Position::Goalkeeper);

        // assert
        assertSame(2, count($team));
    }

    #[TestDox('Тест существования игрока')]
    #[Depends('testAddPlayer')]
    public function testHasPlayer(): void
    {
        // arrange
        $team = new Team('СССР', [
            new Player(number: 17, firstName: 'Валерий', lastName: 'Харламов', position: Position::Forward),
            new Player(number: 7, firstName: 'Геннадий', lastName: 'Цыганков', position: Position::Defender),
            new Player(number: 20, firstName: 'Владислав', lastName: 'Третьяк', position: Position::Goalkeeper),
        ]);

        // act
        $result = isset($team[7]);

        // assert
        assertTrue($result);
    }

    #[TestDox('Тест получения игрока')]
    #[Depends('testHasPlayer')]
    public function testGetPlayer(): void
    {
        // arrange
        $players = [
            new Player(number: 17, firstName: 'Валерий', lastName: 'Харламов', position: Position::Forward),
            new Player(number: 7, firstName: 'Геннадий', lastName: 'Цыганков', position: Position::Defender),
            new Player(number: 20, firstName: 'Владислав', lastName: 'Третьяк', position: Position::Goalkeeper),
        ];
        $team = new Team('СССР', $players);

        // act
        $player = $team[20];

        // assert
        assertSame($players[2], $player);
    }

    #[TestDox('Тест исключения игрока')]
    #[Depends('testGetPlayer')]
    public function testExclusionsPlayer(): void
    {
        // arrange
        $team = new Team('СССР', [
            new Player(number: 17, firstName: 'Валерий', lastName: 'Харламов', position: Position::Forward),
            new Player(number: 7, firstName: 'Геннадий', lastName: 'Цыганков', position: Position::Defender),
            new Player(number: 20, firstName: 'Владислав', lastName: 'Третьяк', position: Position::Goalkeeper),
        ]);

        // act
        unset($team[7]);

        // assert
        assertSame(2, count($team));
    }
}
