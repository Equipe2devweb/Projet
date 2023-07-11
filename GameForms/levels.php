<?php
return [
    [
        'title' => "Level 1 - Arrange Letters in Ascending Order",
        'expectedAnswer' => generateRandomString(6),
        'numInputBoxes' => 6
    ],
    [
        'title' => "Level 2 - Arrange Letters in Descending Order",
        'expectedAnswer' => generateRandomString(6),
        'numInputBoxes' => 6
    ],
    [
        'title' => "Level 3 - Arrange Numbers in Ascending Order",
        'expectedAnswer' => generateRandomNumbers(6),
        'numInputBoxes' => 6
    ],
    [
        'title' => "Level 4 - Arrange Numbers in Descending Order",
        'expectedAnswer' => generateRandomNumbers(6),
        'numInputBoxes' => 6
    ],
    [
        'title' => "Level 5 - Identify the First and Last Letter",
        'expectedAnswer' => generateRandomString(2),
        'numInputBoxes' => 2
    ],
    [
        'title' => "Level 6 - Identify the Smallest and Largest Number",
        'expectedAnswer' => generateRandomNumbers(2),
        'numInputBoxes' => 2
    ]
];


// Function to generate a random string of given length
function generateRandomString($length)
{
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomString;
}


// Function to generate an array of random numbers
function generateRandomNumbers($length)
{
    $numbers = [];
    for ($i = 0; $i < $length; $i++) {
        $numbers[] = rand(1, 100);
    }
    return implode('', $numbers);
}
?>
