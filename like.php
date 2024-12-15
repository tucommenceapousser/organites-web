<?php
// Fonction pour récupérer les données depuis le fichier JSON
function getMessagesData() {
    if (file_exists('messages.json')) {
        // Assurez-vous que le fichier contient du JSON valide
        $data = json_decode(file_get_contents('messages.json'), true);
        if ($data === null) {
            return ['messages' => [], 'likes' => 0, 'messages_count' => 0];
        }
        return $data;
    }
    return ['messages' => [], 'likes' => 0, 'messages_count' => 0];
}

// Fonction pour enregistrer les données dans le fichier JSON
function saveMessagesData($data) {
    file_put_contents('messages.json', json_encode($data, JSON_PRETTY_PRINT));
}

// Récupérer les données existantes
$data = getMessagesData();

// Vérifier si le bouton Like a été cliqué
if (isset($_POST['like'])) {
    // Incrémenter le compteur de likes
    $data['likes']++;
    saveMessagesData($data);
}

// Rediriger vers la page principale
header('Location: index.php');
exit;
?>
