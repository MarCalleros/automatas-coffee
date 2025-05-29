<?php

namespace Controller;

use Model\Usuario;

class APInfc {
    public static function getNFClogin() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['status' => 'error', 'message' => 'Metodo no permitido']);
            return;
        }
        $data = json_decode(file_get_contents('php://input'), true);
        if (!isset($data['nfcId']) || empty($data['nfcId'])) {
            echo json_encode(['status' => 'error', 'message' => 'NFC ID no proporcionado']);
            return;
        }

        $nfcId = $data['nfcId'];
        $Usuario = new Usuario();
        $Usuario -> loginnfc($nfcId);

        echo json_encode([
            'status' => 'success',
            'message' => $nfcId,
        ]);
    }
    public static function getNFClogout() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode(['status' => 'error', 'message' => 'Metodo no permitido']);
            return;
        }
        if (!isset($_SESSION)) {
                        session_start();
        }
        $logoutnfc = $_SESSION['nfc'];

        echo json_encode([
            'status' => 'success',
            'message' => $logoutnfc,
        ]);
    }

}
?>