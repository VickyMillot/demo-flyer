<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header('Content-Type: application/json');

// Chemin vers le fichier JSON
$filePath = __DIR__ . '/../../data/data.json';

// Récupère les données envoyées
$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['section']) || !isset($input['data'])) {
    echo json_encode(['status' => 'error', 'message' => 'Requête invalide']);
    exit;
}

// Charge l'ancien fichier
if (!file_exists($filePath)) {
    echo json_encode(['status' => 'error', 'message' => 'Fichier data introuvable']);
    exit;
}

$data = json_decode(file_get_contents($filePath), true);

// Met à jour la section demandée
$data[$input['section']] = $input['data'];

// Sauvegarde le fichier
if (file_put_contents($filePath, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
    echo json_encode(['status' => 'success']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Erreur lors de la sauvegarde']);
}
