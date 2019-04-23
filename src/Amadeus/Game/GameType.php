<?php


namespace Amadeus\Game;


use Amadeus\IO\Logger;

/**
 * Class GameType
 * @package Amadeus\Game
 */
class GameType
{
    /**
     * @var array
     */
    private $types = array();

    /**
     * GameType constructor.
     */
    public function __construct()
    {
        Logger::printLine('Successfully registered', Logger::LOG_INFORM);
    }

    /**
     * @param string $type
     * @param object $reference
     * @return bool
     */
    public function onGameTypeRegister(string $type, object $reference): bool
    {
        $this->types[$type] = $reference;
        return true;
    }

    /**
     * @param string $type
     * @return bool|mixed
     */
    public function getGameType(string $type)
    {
        return array_key_exists($type,$this->types)?$this->types[$type]:false;
    }
}