<?php
function generateRandomLetters($length)
{
    $letters = "";
    $possibleLetters = "abcdefghijklmnopqrstuvwxyz";

    for ($i = 0; $i < $length; $i++) {
        $letters .= $possibleLetters[rand(0, strlen($possibleLetters) - 1)];
    }

    return $letters;
}

function sortLettersAscending($letters)
{
    $sortedLetters = str_split($letters);
    sort($sortedLetters);
    return implode('', $sortedLetters);
}

$levels = [
    [
        'title' => "Level 1 - Arrange Letters in Ascending Order",
        'randomLetters' => generateRandomLetters(6),
        'numInputBoxes' => 6

        
    ],

    [
        'title' => "Level 2 - Arrange Letters in Ascending Order",
        'randomLetters' => generateRandomLetters(8),
        'numInputBoxes' => 8
    ],
    [
        'title' => "Level 3 - Arrange Letters in Ascending Order",
        'randomLetters' => generateRandomLetters(10),
        'numInputBoxes' => 10
    ]
    ];


foreach ($levels as &$level) {
    $level['expectedAnswer'] = sortLettersAscending($level['randomLetters']);
}

return $levels;
?>
