<!DOCTYPE html>
<html>
<head>
    <title>Game Forms</title>
    <link rel="stylesheet" type="text/css" href="GameForms.css">
</head>
<body>
    <?php
    $levels = include 'levels.php';
    $levelIndex = isset($_POST['levelIndex']) ? $_POST['levelIndex'] : 0;
    $level = $levels[$levelIndex];
    $randomLetters = $level['randomLetters'];
    $numInputBoxes = $level['numInputBoxes'];

    if (isset($_POST['submit'])) {
        $userInput = $_POST['input'];
        $isCorrect = false;

        // Check if the user input matches the expected answer
        $expectedAnswer = $level['expectedAnswer']; // Get the correct expected answer for the level
        $userInputString = implode('', $userInput); // Convert user's input array to a string
        $isCorrect = ($userInputString === $expectedAnswer);

        // Display the result message based on correctness
        $resultMessage = $isCorrect ? 'Congratulations, you got it right!' : 'Sorry, try again!';
    }
    ?>

    <form id="gameForm" class="level" action="Game.php" method="POST">
        <h1 id="levelTitle"><?php echo $level['title']; ?></h1>
        <p id="levelDescription">Instructions: Arrange the given characters/numbers according to the specified order.</p>
        
        <?php if (isset($_POST['submit'])): ?>
            <p id="resultMessage"><?php echo $resultMessage; ?></p>
        <?php endif; ?>

        <p id="lettersToArrange"><?php echo $randomLetters; ?></p> <!-- Display random letters before user input -->

        <?php for ($i = 0; $i < $numInputBoxes; $i++): ?>
            <input type="text" name="input[]" required>
        <?php endfor; ?>

        <input type="hidden" id="levelIndex" name="levelIndex" value="<?php echo $levelIndex; ?>">
        <input type="hidden" name="expectedAnswer" value="<?php echo $level['expectedAnswer']; ?>"> <!-- Add hidden input for expected answer -->
        <button type="submit" name="submit">Submit</button>
        <button id="giveUpButton" type="button">I Give Up!</button>
    </form>
</body>
</html>
