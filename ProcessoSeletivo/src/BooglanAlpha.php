<?php

namespace StudioVisual\ProcessoSeletivo;

require('./src/Booglan.php');

class BooglanAlpha extends Booglan
{
    protected static $alphabet = [
        't','w','h','z','k','d','f','v','c','j','x',
        'l','r','n','q','m','g','p','s','b'
    ];

    public function __construct()
    {
        parent::setDigits(static::$alphabet);
    }

    public function getAlphabet()
    {
        return static::$alphabet;
    }

    public function getValue(string $digit)
    {
        return static::$alphabet[array_search($digit, static::CARACTERS)];
    }

    private function getLastLetter(string $word)
    {
        return substr($word, -1);
    }

    private function hasCaracterFromWord($word, $caracter = 'l')
    {
        $letters = str_split($word);
        
        foreach ($letters as $letter) {
            if ($letter == $caracter) {
                return true;
                break;
            }
        }

        return false;
    }

    public function isPrepositionFromWord(string $word)
    {
        return strlen($word) == 5 
            #&& $this->getLastLetter($word) != 'l'
            && $this->isBar($this->getLastLetter($word))
            && !$this->hasCaracterFromWord($word);
    }

    public function isVerbFromWord(string $word)
    {
        return strlen($word) > 7 && $this->isBar($this->getLastLetter($word));
    }

    public function getFirstLetter(string $word)
    {
        return substr($word, 0, 1);
    }

    public function isVerbFirstPersonFromWord(string $word)
    {
        return $this->isVerbFromWord($word) 
            && $this->isBar($this->getFirstLetter($word));
    }
    
    public function sort(array $words, array $alphaLetters)
    {
        $matriz = [];
        foreach ($words as $key => $word) {
            $lettersWord = str_split($word);
            $matriz[] = $lettersWord;
        }
        for ($w = 0; $w < count($matriz); $w++) {
            for ($l = 0; $l < (count($matriz) - 1) - $w; $l++) {
                $currentLetters = $matriz[$l];
                $nextLetters    = $matriz[$l + 1];
                $valueSmallLength = 0;
                if (count($currentLetters) <= count($nextLetters)) {
                    $valueSmallLength = count($currentLetters);
                } else {
                    $valueSmallLength = count($nextLetters);
                }
                $change = false;
                $isSamePrefix = false;
                /*
                 * Se a primeira letra da palavra corrente for menor do que a primeira letra da proxima palavra: sai do loop
                 * Se a primeira letra da palavra corrente for igual a da primeira letra da proxima palavra: vai pra proxima
                 * Se a primeira letra da palavra corrente for maior do que a primeira letra da proxima palavra: troca posicao
                 */
                for ($i = 0; $i < $valueSmallLength; $i++) {
                    $letterCurIndex = array_search($currentLetters[$i], $alphaLetters);
                    $letterNexIndex = array_search($nextLetters[$i], $alphaLetters);
                    if ($letterCurIndex < $letterNexIndex) {
                        $change = false;
                        $isSamePrefix = false;
                        break;
                    }
                    if ($letterCurIndex == $letterNexIndex) {
                        $isSamePrefix = true;
                        $change = false;
                        continue;
                    }
                    if ($letterCurIndex > $letterNexIndex) {
                        $change = true;
                        $isSamePrefix = false;
                        break;
                    }
                }
                if ($change || ($isSamePrefix 
                    && count($currentLetters) > count($nextLetters))
                ) {
                    $auxLetters = $matriz[$l];
                    $matriz[$l] = $matriz[$l + 1];
                    $matriz[$l + 1] = $auxLetters;
                }
            }
        }
        $textSorted = [];
        foreach ($matriz as $vetor) {
            $textSorted[] = implode($vetor);
        }
        return $textSorted;
    }
}
