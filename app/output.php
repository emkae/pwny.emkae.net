<?php
// Install PSR-4-compatible class autoloader
spl_autoload_register(function ($class) {
    require 'lib' . DIRECTORY_SEPARATOR
        . str_replace('\\', DIRECTORY_SEPARATOR, ltrim($class, '\\')).'.php';
});

$input = '';
$syntax = '';
$output = '';

if (isset($_POST['syntax'])) {
    $syntax = $_POST['syntax'];
} elseif (isset($argv) && count($argv) > 2) {
    $syntax = $argv[1];
}

if ($syntax === '') {
    die();
}

if (isset($_POST['input'])) {
    $input = $_POST['input'];
} elseif (isset($argv) && count($argv) > 2) {
    $input = $argv[2];
}

if ($input === '') {
    die();
}

switch ($syntax) {
    case 'javascript':
        $output = '<script>'.$input.'</script>';
        break;
    case 'markdown':
        $skel = file_get_contents('./lib/com/walialu/markdown-style/markdown-skel.html');
        $transformed = Michelf\MarkdownExtra::defaultTransform($input);
        $output = str_replace('{{content}}', $transformed, $skel);
        break;
    case 'scss':
        require './lib/scssphp/scss.inc.php';
        $scss = new scssc();
        try {
            $output = $scss->compile($input);
        } catch (Exception $ex) {
            $output = $ex->getMessage();
        }
        break;
    default:
        $output = $input;
        break;
}

header("X-XSS-Protection: 0");
echo $output . "\n";
