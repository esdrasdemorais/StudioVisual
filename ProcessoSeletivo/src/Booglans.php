<?php

namespace StudioVisual\ProcessoSeletivo;

require('./src/BooglanAlpha.php');
require('./src/BooglanNumber.php');

class Booglans
{
    protected $booglanAlpha;
    protected $booglanNumber;

    public function __construct()
    {
        $this->booglanAlpha = new BooglanAlpha();
        $this->booglanNumber = new BooglanNumber();
    }

    public function countPrepositions(string $text)
    {
        $words = explode(' ', $text);
        $count = 0;
        
        foreach ($words as $word) {
            if ($this->booglanAlpha->isPrepositionFromWord(trim($word))) {
                $count++;
            }
        }
        
        return $count;
    }

    public function countVerbs(string $text)
    {
        $words = explode(' ', $text);
        $count = 0;
        
        foreach ($words as $word) {
            if ($this->booglanAlpha->isVerbFromWord(trim($word))) {
                $count++;
            }
        }
        
        return $count;
    }

    public function countVerbsFirstPerson(string $text)
    {
        $words = explode(' ', $text);
        $count = 0;

        foreach ($words as $word) {
            if ($this->booglanAlpha->isVerbFirstPersonFromWord(trim($word))) {
                $count++;
            }
        }

        return $count;
    }

    private function inText(string $word, string $textSorted)
    {
        return stripos($textSorted, $word) !== false;
    }

    private function showText(array $textSortedArray)
    {
        $textSorted = '';
        foreach ($textSortedArray as $key => $word) {
            $textSorted .= $word;
            $textSorted .= $key != count($textSortedArray) - 1 ? ' ' : '';
        }
        return $textSorted;
    }

    public function sortText(string $text)
    {
        $booglanAlphaLetters = $this->booglanAlpha->getAlphabet();
        $words = explode(' ', $text);
        $textSorted = [];

        /*foreach ($booglanAlphaLetters as $booglanAlphaLetter) {
            foreach ($words as $key => $word) {
                $firstLetter = $this->booglanAlpha->getFirstLetter($word);
                if ($firstLetter == $booglanAlphaLetter 
                    && !in_array($word, $textSorted)
                ) {
                    $textSorted[] = $word;
                }
            }
        }*/

        $arraySorted = $this->booglanAlpha->sort($words, $booglanAlphaLetters);
        $arraySorted = $this->booglanAlpha->sort($words, $booglanAlphaLetters);
        return $this->showText($arraySorted);
    }

    public function countPrettyNumbers(string $text)
    {
        $words = explode(' ', $text);
        $count = 0;
        $pretties = [];

        foreach ($words as $word) {
            if ($this->booglanNumber->isPrettyNumber($word, $pretties)) {
                $count++;
            }
        }

        return $count;
    }
}
