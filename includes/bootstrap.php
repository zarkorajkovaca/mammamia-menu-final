<?php
declare(strict_types=1);
header('Content-Type: text/html; charset=utf-8');
header('X-Content-Type-Options: nosniff');
header('Referrer-Policy: strict-origin-when-cross-origin');
header("Content-Security-Policy: default-src 'self'; script-src 'self'; style-src 'self'; img-src 'self' data: blob:; object-src 'none'; base-uri 'self'; frame-ancestors 'self'; form-action 'self'");
function e($value): string { return htmlspecialchars((string)$value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8'); }
function data(string $name): array {
    try {
        $result = json_decode(file_get_contents(__DIR__ . '/../data/' . $name . '.json'), true, 512, JSON_THROW_ON_ERROR);
        if (!is_array($result)) { throw new RuntimeException('Invalid data'); }
        return $result;
    } catch (Throwable $error) {
        error_log('Menu data error: ' . $error->getMessage());
        http_response_code(500);
        exit('Cenovnik trenutno nije dostupan. Molimo pokušajte kasnije. / Menu temporarily unavailable.');
    }
}
$languages = ['sr'=>'Srpski', 'en'=>'English', 'hu'=>'Magyar', 'de'=>'Deutsch', 'es'=>'Español', 'ru'=>'Русский'];
$requested = $_GET['lang'] ?? 'sr';
$lang = is_string($requested) && isset($languages[$requested]) ? $requested : 'sr';
$site = data('site');
$translations = data('translations');
$t = $translations[$lang];
function money($value): string { return number_format((float)$value, 0, ',', '.'); }
function page_head(string $title, string $lang): void { ?>
<!doctype html>
<html lang="<?= e($lang) ?>">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="theme-color" content="#1b2024">
<meta name="description" content="Pizzeria Mamma Mia Sombor — online jelovnik / food & drinks menu.">
<title><?= e($title) ?> · Mamma Mia Sombor</title>
<link rel="icon" href="assets/img/logo.png"><link rel="stylesheet" href="assets/style.css">
</head>
<?php }
