<?php

class TextProcessor
{
    /**
     * Function to remove punctuation from a string.
     *
     * @param string $text The string you want to remove scores from.
     * @return string The string without the scores.
     */

    public static function sanitizeText($text)
    {
        $pattern = '/[[:punct:]]/u';
        $textoSemPontuacoes = preg_replace($pattern, '', $text);
        return $textoSemPontuacoes;
    }
}
