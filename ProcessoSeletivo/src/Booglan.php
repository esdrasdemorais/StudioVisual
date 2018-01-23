<?php

namespace StudioVisual\ProcessoSeletivo;

require('./src/Interfaces/CaracterInterface.php');

use StudioVisual\ProcessoSeletivo\Interfaces;

abstract class Booglan implements CaracterInterface
{
    const FOO = 'FOO', BAR = 'BAR';
    protected static $alphabet = [];
    protected static $foo = ['r', 't', 'c', 'd', 'b'];

    abstract protected function getValue(string $digit);
    
    public function setDigits(array $digits)
    {
        static::$alphabet = $digits;
    }

    protected function isFoo(string $digit)
    {
        return in_array($digit, static::$foo);
    }

    protected function isBar(string $digit)
    {
        return false === in_array($digit, static::$foo);
    }
    
    public function getType(string $digit)
    {
        return true === $this->isFoo($digit) ? static::FOO : self::BAR;
    }
}
