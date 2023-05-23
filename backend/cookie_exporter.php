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
    private $cookiesRepository;

    /**
     * Constructor.
     *
     * @param CookiesRepository $cookiesRepository Repository for saving cookies.
     */
    public function __construct(CookiesRepository $cookiesRepository)
    {
        $this->cookiesRepository = $cookiesRepository;
    }

    /**
     * Exports the received cookies.
     *
     * @param array $cookies Array of cookies.
     * @throws RuntimeException If there was an error exporting the cookies.
     */
    public function exportCookies(array $cookies): void
    {
        $this->cookiesRepository->saveCookies($cookies);
    }
}

/**
 * Class CookiesRepository
 *
 * Repository for saving cookies.
 */
class CookiesRepository
{
    /**
     * Saves the cookies to a JSON file.
     *
     * @param array $cookies Array of cookies.
     * @throws RuntimeException If there was an error saving the cookies.
     */
    public function saveCookies(array $cookies): void
    {
        $cookiesFile = 'cookies.json';

        if (!file_put_contents($cookiesFile, json_encode($cookies))) {
            throw new RuntimeException('Error exporting cookies');
        }
    }
}

// Enable error reporting for debugging purposes
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

try {
    $data = json_decode(file_get_contents('php://input'), true);
    $message = 'Invalid data received';

    http_response_code(
        match (true) {
            isset($data['cookies']) && is_array($data['cookies']) => {
                $cookiesRepository = new CookiesRepository();
                $cookieExporter = new CookieExporter($cookiesRepository);
                $cookieExporter->exportCookies($data['cookies']);
                $message = 'Cookies exported successfully';
                200;
            },
            default => 400,
        }
    );

    echo json_encode(['message' => $message]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['message' => $e->getMessage()]);
}
