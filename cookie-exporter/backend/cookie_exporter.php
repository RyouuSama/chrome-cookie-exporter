<?php

// Enable CORS on your server to allow communication with your extension.
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

/**
 * Class CookieExporter
 *
 * Exports cookies sent by a Chrome extension.
 */
class CookieExporter
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if (isset($data['cookies'])) {
            $result = $this->processCookies($data['cookies']);

            if ($result) {
                http_response_code(200);
                echo json_encode(['message' => 'Cookies exported successfully']);
            } else {
                http_response_code(500);
                echo json_encode(['message' => 'Error exporting cookies']);
            }
        }
    }

    /**
     * Processes the received cookies.
     *
     * @param array $cookies Array of cookies.
     * @return bool Returns true if the cookies were processed successfully, false otherwise.
     */
    private function processCookies(array $cookies): bool
    {
        $cookiesFile = 'cookies.json';

        // Save the cookies to a JSON file
        if (file_put_contents($cookiesFile, json_encode($cookies))) {
            return true;
        } else {
            return false;
        }
    }
}

// Initialize the CookieExporter class
new CookieExporter();
