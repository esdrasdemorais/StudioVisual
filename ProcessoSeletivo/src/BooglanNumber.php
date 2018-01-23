<?php

namespace StudioVisual\ProcessoSeletivo;

class BooglanNumber extends Booglan
{
    protected static $alphabet = [
        't','w','h','z','k','d','f','v','c','j','x',
        'l','r','n','q','m','g','p','s','b'
    ];

    public function __construct()
    {
        parent::setDigits(static::$alphabet);
    }


    public function getValue(string $digit)
    {
        return array_search($digit, static::$alphabet);
    }

    public function isPrettyNumber(string $digits, array &$pretties)
    {
        $number = $this->getDecimalFromDigits($digits);
        $isPretty = $number > 422224 && ($number % 3 == 0);
        if (true === $isPretty && !in_array($digits, $pretties)) {
            $pretties[] = $digits;
            return true;
        }
        return false;
    }

    public function getBase20($n)
    {
        $base20 = [0 => 0, 1 => 20];
        for ($i = 2; $i < $n; $i++) {
            $base20[$i] = $base20[$i - 1] * 20;
        }
        return $base20;
    }

    /**
     * unidade   		    - 0               = 0 
     * duzena    		    - 1          * 20 = 20
     * ducentena 		    - 20         * 20 = 400
     * dumilhar 		    - 400        * 20 = 8000 
     * ducentena de milhar	- 8000       * 20 = 160000
     * dumilhao 		    - 160000     * 20 = 3200000
     * ducentena de milhao  - 3200000    * 20 = 64000000
     * dubilhao             - 64000000   * 20 = 1280000000
     * ducentena de bilhao  - 1280000000 * 20 = 25600000000
     *
     * hnh = 1062
     * h = 2
     * n = 13 * 20 = 260
     * h = 2 * 400 = 800
     */
    public function getDecimalFromDigits(string $digits)
    {
        $caracters = str_split($digits);
        $number = $sum = 0;
        $base20 = $this->getBase20(count($caracters));
        
        foreach ($caracters as $unit => $caracter) {
            if ($unit == 0) {
                $sum = $this->getDecimalFromDigit($caracter);
                continue;
            }
            $number = $this->getDecimalFromDigit($caracter) * $base20[$unit];
            $sum += $number;
        }

        return $sum;
    }

    public function getDecimalFromDigit(string $caracter)
    {
        return $this->getValue($caracter);
    }
}
