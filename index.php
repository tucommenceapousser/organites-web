<?php
// Fonction pour récupérer les données depuis le fichier JSON
function getMessagesData() {
    if (file_exists('messages.json')) {
        return json_decode(file_get_contents('messages.json'), true);
    }
    return ['messages' => [], 'likes' => 0, 'messages_count' => 0];
}

// Fonction pour enregistrer les données dans le fichier JSON
function saveMessagesData($data) {
    file_put_contents('messages.json', json_encode($data, JSON_PRETTY_PRINT));
}

// Gérer l'ajout d'un like
if (isset($_POST['like'])) {
    $data = getMessagesData();
    $data['likes']++;
    saveMessagesData($data);
}

// Gérer l'envoi d'un message
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !isset($_POST['like'])) {
    $contact = htmlspecialchars($_POST['contact']);
    $comment = htmlspecialchars($_POST['comment']);
    $uploadDir = 'uploads/';
    $responseMessage = '';

    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    // Récupérer les données existantes
    $data = getMessagesData();

    // Créer un tableau pour les nouvelles données de message
    $newMessage = [
        'contact' => $contact,
        'comment' => $comment,
        'date' => date('Y-m-d H:i:s') // Ajoute la date et l'heure
    ];

    // Ajouter le nouveau message
    $data['messages'][] = $newMessage;
    $data['messages_count']++;

    // Sauvegarder le tableau mis à jour dans le fichier JSON
    saveMessagesData($data);

    // Gérer le téléchargement de photo si une image est envoyée
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $photoTmpName = $_FILES['photo']['tmp_name'];
        $photoName = basename($_FILES['photo']['name']);
        $photoPath = $uploadDir . $photoName;

        // Déplacer le fichier téléchargé vers le répertoire de destination
        if (move_uploaded_file($photoTmpName, $photoPath)) {
            $responseMessage = 'Message et photo envoyés avec succès!';
        } else {
            $responseMessage = 'Erreur lors du téléchargement de la photo.';
        }
    } else {
        $responseMessage = 'Votre message a été envoyé avec succès!';
    }

    // Afficher un message de confirmation
    echo "<div style='color: #39ff14; text-align: center; margin-top: 20px;'>$responseMessage</div>";
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orgonites par trhacknon</title>
    <!-- Meta tags -->
    <meta name="description" content="Découvrez les créations artisanales d'orgonites par trhacknon, conçues à partir de résine, cuivre, quartz, et autres matériaux uniques.">
    <meta name="keywords" content="orgonites, trhacknon, art énergétique, cuivre, quartz, obsidienne, artisanat, création manuelle">
    <meta name="author" content="trhacknon">
    <meta property="og:title" content="Orgonites par trhacknon">
    <meta property="og:description" content="Transformez les énergies négatives avec nos créations artisanales uniques d'orgonites.">
    <meta property="og:image" content="orgoo.jpg">
    <meta property="og:url" content="https://orgo-trkn.replit.app">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Orgonites par trhacknon">
    <meta name="twitter:description" content="Découvrez les créations artisanales d'orgonites uniques.">
    <meta name="twitter:image" content="orgoo.jpg">
          <link rel="stylesheet" href="like.css">
          <link rel="stylesheet" href="stys.css">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            background: #000;
            color: #fff;
            font-family: Roboto, Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        

        header {
            background: linear-gradient(145deg, #121212, #39ff14);
            color: #fff;
            padding: 20px;
            text-align: center;
            position: relative;
            text-shadow: 0 0 10px #39ff14, 0 0 20px #ff0000;
            animation: fadeInDown 1s ease-out;
        }

        header h1 {
            font-size: 3em;
            margin-bottom: 10px;
            animation: fadeInDown 1s ease-out;
            text-shadow: 0 0 10px #ff0000, 0 0 20px #fff000;
        }

        header p {
            font-size: 1.2em;
            margin-bottom: 20px;
            animation: fadeInUp 1s ease-out;
            text-shadow: 0 0 10px #39ff14, 0 0 20px #39ff14;
        }


        .container {
            max-width: 900px;
            margin: 20px auto;
            padding: 20px;
            background: #121212;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(57, 255, 20, 0.6);
        }

        .container img {
            width: 100%;
            max-height: 400px;
            object-fit: cover;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 4px 10px rgba(57, 255, 20, 0.6);
        }

        .container p, .container h2, .container ul li {
            font-size: 1.2em;
            line-height: 1.6;
            color: #e0e0e0;
        }

        .container h2 {
            color: #39ff14;
            text-shadow: 0 0 10px #39ff14, 0 0 20px #39ff14;
        }

        .explanation {
            margin: 20px 0;
            padding: 20px;
            background: #181818;
            border-left: 5px solid #39ff14;
            border-radius: 5px;
            box-shadow: 0 4px 10px rgba(57, 255, 20, 0.6);
            animation: fadeInDown 2s ease-out;
        }

        .gallery {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            justify-content: center;
        }

        .gallery img {
            width: 200px;
            height: 200px;
            object-fit: cover;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(57, 255, 20, 0.6);
            transition: transform 0.3s;
        }

        .gallery img:hover {
            transform: scale(1.1);
        }

        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: #39ff14;
            color: #000;
            text-decoration: none;
            font-weight: bold;
            border-radius: 5px;
            transition: background 0.3s, color 0.3s;
        }

        .btn:hover {
            background: #000;
            color: #39ff14;
            border: 2px solid #39ff14;
        }

        footer {
            text-align: center;
            padding: 20px;
            background: #121212;
            border-top: 2px solid #39ff14;
            color: #39ff14;
            text-shadow: 0 0 5px #39ff14, 0 0 10px #39ff14;
            animation: fadeInDown 1s ease-out;
        }

        form {
            margin-top: 20px;
            background: #181818;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(57, 255, 20, 0.6);
        }

        form input, form textarea, form button {
            width: 100%;
            margin-bottom: 15px;
            padding: 10px;
            border: none;
            border-radius: 5px;
            font-size: 1em;
        }

        form button {
            background: #39ff14;
            color: #000;
            font-weight: bold;
            cursor: pointer;
        }

        form button:hover {
            background: #000;
            color: #39ff14;
            border: 2px solid #39ff14;
        }

        .like-button {
            background: #39ff14;
            color: #000;
            font-weight: bold;
            padding: 10px;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            display: inline-block;
            margin-top: 20px;
            width: 200px;
        }

        .like-button:hover {
            background: #000;
            color: #39ff14;
            border: 2px solid #39ff14;
        }
        .shadow-text {
            color: #FF0000; /* rouge classique */
            font-weight: bold;
            text-shadow: 1px 1px 2px rgba(255, 0, 0, 0.8); /* ombre rouge */
        }
        header img {
            max-width: 80%;
            height: auto;
            border: 2px solid #00ffcc;
            box-shadow: 0 0 15px #00ffcc;
        }
    </style>
</head>
<body>
    <header>
        <img src="https://i.top4top.io/p_3262ph7ir3.jpg" alt="Header Image">
        <h1>Orgonites par trhacknon</h1>
    </header>

    <div class="container">
        <img max-height="50%" src="orgoo.jpg" alt="Orgonite magnifique">
        <p>Bienvenue dans mon univers artisanal !</p>
        <div class="explanation">
            <h2>Comment fonctionne une orgonite ?</h2>
            <p>Les orgonites combinent des matériaux pour transformer les énergies négatives en vibrations équilibrées.</p>
            <ul>
                <li><strong>Cuivre :</strong> Canalise et conduit les énergies.</li>
                <li><strong>Quartz :</strong> Amplifie et équilibre les vibrations.</li>
                <li><strong>Obsidienne :</strong> Neutralise les énergies négatives.</li>
            </ul>
        </div>

        <h2>Statistiques</h2>
        <?php
        // Récupérer les données
        $data = getMessagesData();
        echo "<p>Nombre de messages : </p><p class='shadow-text'>" . $data['messages_count'] . "</p>";
        echo "<p>Nombre de likes : </p><p class='shadow-text'>" . $data['likes'] . "</p>";
        ?>

        <h2>Galerie de nos créations</h2>
        <div class="gallery">
            <img src="orgoai.webp" alt="Orgonite 1">
            <img src="orgo1.jpeg" alt="Orgonite 2">
            <img src="orgo2.jpeg" alt="Orgonite 3">
            <img src="organites.jpg" alt="Orgonite 4">
        </div>
        <form action="" method="POST" enctype="multipart/form-data">
            <h2>Envoyer un message</h2>
            <label for="contact">Nom / Contact</label>
            <input type="text" id="contact" name="contact" required>

            <label for="comment">Message</label>
            <textarea id="comment" name="comment" rows="4" required></textarea>

            <label for="photo">Ajouter une photo (optionnel)</label>
            <input type="file" id="photo" name="photo">

            <button type="submit">Envoyer le message</button>
        </form>

        <div class="like-button">
            <form action="" method="POST">
                <button type="submit" name="like" id="likeBtn">Like 👍</button>

                <!-- Section pour afficher l'emoji du pouce -->
                <div id="thumbContainer" class="thumb-container"></div>
            </form>
        </div>

        <h2>Messages reçus</h2>
        <?php
        // Affichage des messages envoyés
        if (!empty($data['messages'])) {
            foreach ($data['messages'] as $message) {
                echo "<div class='message'>";
                echo "<p><strong>" . htmlspecialchars($message['contact']) . "</strong> a écrit le " . htmlspecialchars($message['date']) . " :</p>";
                echo "<p>" . nl2br(htmlspecialchars($message['comment'])) . "</p>";

                // Afficher l'image si elle existe
                if (isset($message['photo']) && file_exists('uploads/' . $message['photo'])) {
                    echo "<img src='uploads/" . htmlspecialchars($message['photo']) . "' alt='Photo du message'>";
                }
                echo "</div>";
            }
        } else {
            echo "<p>Aucun message n'a été envoyé pour le moment.</p>";
        }
        ?>
    </div>

    <footer>
        <p>&copy; 2024 Orgonites par trhacknon | Tous droits réservés.</p>
    </footer>
    <script src="script.js"></script>
</body>
</html>
