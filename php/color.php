<?php


/* for ($i = 0; $i < 100; $i++){
    echo "\e[{$i}m color {$i} \r\n";
} */


function getDarkGray() : string{
    return "\e[90m";
}

function getDarkRed() : string{
    return "\e[31m";
}

function getDarkGreen() : string{
    return "\e[32m";
}

function getDarkYellow() : string{
    return "\e[33m";
}

function getDarkBlue() : string{
    return "\e[34m";
}

function getDarkPurple() : string{
    return "\e[35m";
}

function getDarkSkyblue() : string{
    return "\e[m";
}

// end dark colors

function getGray() : string{
    return "\e[0m";
}

function getRed() : string{
    return "\e[91m";
}

function getGreen() : string{
    return "\e[92m";
}

function getCyan() : string{
    return "\e[93m";
}

function getBlue() : string{
    return "\e[94m";
}

function getPurpule() : string{
    return "\e[95m";
}

function getLightBlue() : string{
    return "\e[96m";
}

function getResetColor() : string{
    return "\e[39m";
}

// end

function isColorExists() : bool{
    return True;
}


function syntax(string $text, int $mode) : string{

    switch ($mode):

        case 0:
            return (string) (getRed() . "$text" .  getResetColor());
        break;

        case 1:
            return (string) (getGreen() . "$text" .  getResetColor());
        break;

        case 2:
            return (string) (getBlue() . "$text" . getResetColor());
        break;

        default:
            return $text;


    endswitch;
}


function removeLettersAfterCustomByte(string $text, $keepLetterCount) : string{
    $letters = str_split($text);
    $slice = array_slice($letters, 0, $keepLetterCount);
    $text = implode($slice);
    return $text;
}
