<?php
// Code de connexion à la base de données
$host = 'localhost';
$username = 'nom_utilisateur';
$password = 'mot_de_passe';
$dbname = 'nom_base_de_donnees';

// Vérifier si l'utilisateur est connecté (exemple : vous aurez votre propre logique d'authentification)
$isLoggedIn = true;
$username = "JohnDoe"; // Remplacez par le nom d'utilisateur réel

try {
    // Création de la connexion à la base de données
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);

    // Vérifier si l'utilisateur a déjà commencé un jeu
    $query = "SELECT levelcompleted FROM partie WHERE utilisateur = :utilisateur";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':utilisateur', $username);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    $levelCompleted = $row['levelcompleted'];

    // Déconnexion de la base de données
    $conn = null;
} catch (PDOException $e) {
    // Gérer les erreurs de connexion à la base de données
    echo "Erreur de connexion à la base de données : " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Main Menu</title>
    <script>
  window.fbAsyncInit = function() {
    FB.init({
      appId: 'YOUR_APP_ID',
      autoLogAppEvents: true,
      xfbml: true,
      version: 'v12.0'
    });
  };

  // Load the Facebook SDK asynchronously
  (function(d, s, id) {
    var js, fjs = d.getElementsByTagName(s)[0];a
    if (d.getElementById(id)) return;
    js = d.createElement(s); js.id = id;
    js.src = "https://connect.facebook.net/en_US/sdk.js";
    fjs.parentNode.insertBefore(js, fjs);
  }(document, 'script', 'facebook-jssdk'));

  // Function to share the score on Facebook
  function shareScore(level, speed) {
    FB.ui({
      method: 'share',
      href: 'https://your-game-website.com',
      quote: 'I reached level ' + level + ' with a speed of ' + speed + ' in this awesome typing game!',
    }, function(response){});
  }
  
  // Trigger the share function when the share button is clicked
  document.getElementById('fb-share-button').addEventListener('click', function() {
    shareScore(level, speed);
  });
</script>

</head>
<body>
    <h1>Hello <?php echo $username; ?>, welcome to our game!</h1>
    <div id="fb-share-button"></div>

    <h2>Main Menu</h2>

    <?php if ($levelCompleted > 0) : ?>
        <p>Continue Game</p>
    <?php endif; ?>

    <p>Start a New Game</p>

    <form action="/logout" method="POST">
        <input type="submit" value="Logout">
    </form>
</body>
</html>
