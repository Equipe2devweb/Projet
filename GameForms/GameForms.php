<!DOCTYPE html>
<html>

<head>
    <title>Game Forms</title>
    <link rel="stylesheet" type="text/css" href="GameForms.css">
</head>

<body>
    <?php
    $levels = include 'levels.php';
    $levelIndex = $_POST['levelIndex'] ?? 0;
    $level = $levels[$levelIndex];
    ?>

    <form id="gameForm" class="level" action="Game.php" method="POST">
        <h1 id="levelTitle"><?php echo $level['title']; ?></h1>
        <p id="levelDescription">Instructions: Arrange the given characters/numbers according to the specified order.</p>
        <?php
        $expectedAnswer = $level['expectedAnswer'];
        $shuffledLetters = str_shuffle($expectedAnswer);
        echo '<p id="lettersToArrange">' . $expectedAnswer . '</p>';

        $numInputBoxes = $level['numInputBoxes'];
        for ($i = 0; $i < $numInputBoxes; $i++) {
            echo '<input type="text" name="input[]" required>';
        }
        ?>
        <input type="hidden" id="levelIndex" name="levelIndex" value="<?php echo $levelIndex; ?>">
        <input type="hidden" id="expectedAnswer" name="expectedAnswer" value="<?php echo $expectedAnswer; ?>">
        <button type="submit" name="submit">Submit</button>
        <button id="giveUpButton" type="button">I Give up!</button>
    </form>
</body>

</html>










