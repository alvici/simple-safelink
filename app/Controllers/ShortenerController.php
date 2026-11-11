<?php

namespace App\Controllers;

class ShortenerController extends Controller
{
    // Maximum length of the generated short code.
    const CODE_LENGTH = 7;
    // Ambiguous characters (0, o, 1, l, i) are skipped for readability.
    const ALPHABET = 'abcdefghjkmnpqrstuvwxyz23456789';

    public function create()
    {
        $body = trim((string) \Flight::request()->getBody());
        if ($body === '') {
            $body = trim((string) $this->post('url'));
        }

        if ($body === '') {
            return app()->json([
                'success' => false,
                'message' => 'URL is required.'
            ], 422);
        }

        $lines = preg_split('/\r\n|\r|\n/', $body);
        $store = $this->read_store();
        $created = array();
        $errors = array();

        foreach ($lines as $index => $line) {
            $line = trim($line);
            if ($line === '') continue;

            $lineNumber = $index + 1;
            $url = $this->normalize_url($line);

            if ($url === null) {
                $errors[] = 'Line ' . $lineNumber . ': not a valid http or https URL.';
                continue;
            }

            if ($this->is_own_short_link($url)) {
                $errors[] = 'Line ' . $lineNumber . ': that link is already a short link.';
                continue;
            }

            $code = $this->make_code($store);
            $store[$code] = [
                'url' => $url,
                'created' => time(),
            ];
            $created[] = [
                'code' => $code,
                'url' => $url,
                'short' => base_url('s/' . $code),
            ];
        }

        if (empty($created)) {
            return app()->json([
                'success' => false,
                'message' => !empty($errors) ? implode(' ', $errors) : 'No links found.',
            ], 422);
        }

        if (!$this->write_store($store)) {
            return app()->json([
                'success' => false,
                'message' => 'Could not save the short link. Check folder permissions.'
            ], 500);
        }

        return app()->json([
            'success' => true,
            'data' => $created,
            'errors' => $errors,
        ]);
    }

    public function redirect($code = null)
    {
        $code = strtolower(trim((string) $code));
        $store = $this->read_store();

        if ($code === '' || !isset($store[$code]['url'])) {
            http_response_code(404);
            header('Content-Type: text/html; charset=UTF-8');
            echo '<!DOCTYPE html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>Short link not found</title></head>'
                . '<body style="margin:0;min-height:100vh;display:grid;place-items:center;background:#06080f;color:#e7ecf5;font-family:system-ui,sans-serif;text-align:center;padding:24px">'
                . '<div><h1 style="font-size:1.4rem;margin:0 0 8px">Short link not found</h1>'
                . '<p style="margin:0;color:#8b97ad">This link is invalid or has been removed.</p></div></body></html>';
            exit;
        }

        app()->redirect($store[$code]['url'], 302);
        exit;
    }

    private function normalize_url($url)
    {
        if (strlen($url) > 2048) return null;

        // Reject anything containing whitespace or control characters.
        if (preg_match('/[\s\x00-\x1F\x7F]/', $url)) return null;

        // Add a scheme when the user pastes a bare domain.
        if (!preg_match('#^[a-z][a-z0-9+\-.]*://#i', $url)) {
            $url = 'https://' . $url;
        }

        $scheme = strtolower((string) parse_url($url, PHP_URL_SCHEME));
        $host = strtolower((string) parse_url($url, PHP_URL_HOST));
        $hasDot = (strpos($host, '.') !== false);

        if (
            !filter_var($url, FILTER_VALIDATE_URL) ||
            !in_array($scheme, ['http', 'https'], true) ||
            $host === '' ||
            (!$hasDot && $host !== 'localhost')
        ) {
            return null;
        }

        return $url;
    }

    private function is_own_short_link($url)
    {
        $host = strtolower((string) parse_url($url, PHP_URL_HOST));
        $path = (string) parse_url($url, PHP_URL_PATH);

        return $host === strtolower((string) parse_url(base_url(), PHP_URL_HOST))
            && strpos($path, '/s/') !== false;
    }

    private function store_path()
    {
        return BASEPATH . '/resources/shortlinks.json';
    }

    private function read_store()
    {
        $path = $this->store_path();
        if (!file_exists($path)) return array();

        $raw = @file_get_contents($path);
        if ($raw === false || trim($raw) === '') return array();

        $data = json_decode($raw, true);
        return is_array($data) ? $data : array();
    }

    private function write_store(array $store)
    {
        $json = json_encode($store, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        if ($json === false) return false;
        return @file_put_contents($this->store_path(), $json, LOCK_EX) !== false;
    }

    private function make_code(array $store)
    {
        $alphabet = self::ALPHABET;
        $max = strlen($alphabet) - 1;

        do {
            $code = '';
            for ($i = 0; $i < self::CODE_LENGTH; $i++) {
                $code .= $alphabet[random_int(0, $max)];
            }
        } while (isset($store[$code]));

        return $code;
    }
}
