<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once '../vendor/autoload.php';

session_start();
date_default_timezone_set('Europe/London');
define('DIR', $_SERVER['DOCUMENT_ROOT']);

define('SITENAME', 'CodeLighter');

define("EMAIL_NAME", "");
define("EMAIL_HOST", "");
define("EMAIL_USERNAME", "");
define("EMAIL_PASSWORD", "");

define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'root');
define('DB_NAME', 'BelaRuza');

$init = \CodeLighter\Core::init([
    'css' => [
        [
            'home', [
                "https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css"
            ]
        ]
    ], 'js' => [
        [
            'home', [
                "https://code.jquery.com/jquery-3.6.0.min.js",
            ]
        ]
    ]
]);
?>
<!DOCTYPE html>
<html>

<head>
    <title><?= $init['title'] ?></title>
    <meta charset="utf-8">
    <meta name="description" content="<?= $init['description'] ?>">
    <meta name="keywords" content="<?= $init['keywords'] ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php \CodeLighter\Stylesheet::page($init); ?>
    <?php \CodeLighter\Javascript::page($init); ?>
</head>

<?php content($init['view'] . '.php', $init); ?>

</html>
<!-- sudo chmod -R a+rwX /var/www/html -->