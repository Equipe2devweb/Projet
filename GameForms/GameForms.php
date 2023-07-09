<?php
// Retrieve the user's input from the form
$userInput = $_POST['input'];
$levelIndex = $_POST['levelIndex'];

// Define the levels array with their expected answers
$levels = [
    [
        'title' => "Level 1 - Arrange Letters in Ascending Order",
        'expectedAnswer' => 'ABCDEF'
    ],
    [
        'title' => "Level 2 - Arrange Letters in Descending Order",
        'expectedAnswer' => 'FEDCBA'
    ],
    [
        'title' => "Level 3 - Arrange Numbers in Ascending Order",
        'expectedAnswer' => '123456'
    ],
    [
        'title' => "Level 4 - Arrange Numbers in Descending Order",
        'expectedAnswer' => '654321'
    ],
    [
        'title' => "Level 5 - Identify the First and Last Letter",
        'expectedAnswer' => 'AF'
    ],
    [
        'title' => "Level 6 - Identify the Smallest and Largest Number",
        'expectedAnswer' => '16'
    ]
];

// Check if the user input matches the expected answer for the current level
if ($userInput === $levels[$levelIndex]['expectedAnswer']) {
    // User succeeded in the current level
    if ($levelIndex === count($levels) - 1) {
        // User completed all levels
        echo "<h1>Congratulations! You completed all levels successfully.</h1>";
        echo "<p>Well done!</p>";
        echo "<button onclick=\"location.href='GameForms.html'\">Play Again</button>";
    } else {
        // User completed the current level
        echo "<h1>Success!</h1>";
        echo "<p>Congratulations! You completed the level successfully.</p>";
        echo "<p>Proceed to the next level.</p>";
        echo "<button onclick=\"location.href='GameForms.html'\">Next Level</button>";
    }
} else {
    // User failed in the current level
    echo "<h1>Failure!</h1>";
    echo "<p>Oops! Your arrangement is incorrect.</p>";
    echo "<p>Please try again.</p>";
    echo "<button onclick=\"location.href='GameForms.html'\">Try Again</button>";
}
?>
