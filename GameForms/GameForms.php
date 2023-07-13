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
    $username = "John Doe";
    $lives = 5;

    if (isset($_POST['submit'])) {
        $userInput = $_POST['input'];
        $isCorrect = false;

        // Check if the user input matches the expected answer
        $expectedAnswer = $level['expectedAnswer']; // Get the correct expected answer for the level
        $userInputString = implode('', $userInput); // Convert user's input array to a string
        $isCorrect = (strcasecmp($userInputString, $expectedAnswer) === 0);

        // Display the result message based on correctness
        $resultMessage = $isCorrect ? 'Congratulations, you got it right!' : 'Sorry, try again!';
        
        /* Check if all levels are completed successfully
        if ($levelIndex === count($levels) - 1 && $isCorrect) {
            echo "<h1>Congratulations! You completed all levels successfully.</h1>";
            echo "<p>Well done!</p>";
            echo "<button onclick=\"location.href='GameForms.php'\">Play Again</button>";
            exit; // Stop further processing
        }*/
    }

    if (isset($_POST['giveUp'])) {
        $giveUp = true;
        echo "<h1>Partie incomplète (partie abandonnée ou compte utilisateur déconnecté: cancel, time-out ou sign-out)</h1>";
        echo "<p>Le joueur a abandonné la partie de jeu en cours.</p>";
        echo "<p>Partie terminée.</p>";
    } else {
        $giveUp = false;
    }
    ?>

    <form id="gameForm" class="level" action="Game.php" method="POST">
    <div class="header">
        <div class="top-left">
            User: <?php echo $username; ?>
        </div>
        <div class="top-right">
            Lives: <?php echo $lives; ?>
        </div>
    </div>

        <h1 id="levelTitle"><?php echo $level['title']; ?></h1>
        <p id="levelDescription">Instructions: Arrange the given characters/numbers according to the specified order.</p>
        
        <?php if (isset($_POST['submit'])): ?>
            <p id="resultMessage"><?php echo $resultMessage; ?></p>
        <?php endif; ?>

        <p id="lettersToArrange"><?php echo $randomLetters; ?></p> <!-- Display random letters before user input -->
        
        <?php if (!$giveUp): ?>
            <?php for ($i = 0; $i < $numInputBoxes; $i++): ?>
                <input type="text" name="input[]" required>
            <?php endfor; ?>
        <?php endif; ?>
        
        <input type="hidden" id="levelIndex" name="levelIndex" value="<?php echo $levelIndex; ?>">
        <input type="hidden" name="expectedAnswer" value="<?php echo $level['expectedAnswer']; ?>"> <!-- Add hidden input for expected answer -->
        <?php if (!$giveUp): ?>
            <button type="submit" name="submit">Submit</button>
            <button id="giveUpButton" type="submit" name="giveUp" formnovalidate>I Give Up!</button>
        <?php endif; ?>
    </form>
</body>
</html>

