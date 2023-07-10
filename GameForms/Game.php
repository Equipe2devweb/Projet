<?php
$levels = include 'levels.php';

$levelIndex = $_POST['levelIndex'] ?? 0;
$level = $levels[$levelIndex];
$userInput = $_POST['input'] ?? null;

// Convert user's input array to a string
$userInputString = implode('', $userInput);

// Check if the user input matches the expected answer for the current level
if ($userInputString === $level['expectedAnswer']) {
    // User succeeded in the current level
    if ($levelIndex === count($levels) - 1) {
        // User completed all levels
        echo "<h1>Congratulations! You completed all levels successfully.</h1>";
        echo "<p>Well done!</p>";
        echo "<button onclick=\"location.href='GameForms.php'\">Play Again</button>";
    } else {
        // User completed the current level
        echo "<h1>Success!</h1>";
        echo "<p>Congratulations! You completed the level successfully.</p>";
        echo "<p>Proceed to the next level.</p>";
        $nextLevelIndex = $levelIndex + 1;
        echo "<form action=\"GameForms.php\" method=\"post\">";
        echo "<input type=\"hidden\" name=\"levelIndex\" value=\"$nextLevelIndex\">";
        echo "<button type=\"submit\">Next Level</button>";
        echo "</form>";
    }
} else {
    // User failed in the current level
    echo "<h1>Failure!</h1>";
    echo "<p>Oops! Your arrangement is incorrect.</p>";
    echo "<p>Please try again.</p>";
    echo "<p>Expected Answer: " . $level['expectedAnswer'] . "</p>";
    echo "<p>User Input: " . $userInputString . "</p>";
    echo "<form action=\"GameForms.php\" method=\"post\">";
    echo "<input type=\"hidden\" name=\"levelIndex\" value=\"$levelIndex\">";
    echo "<button type=\"submit\">Try Again</button>";
    echo "</form>";
}
?>







