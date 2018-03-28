<?php

$input = '';
$syntax = '';
$output = '';

if (isset($_POST['syntax'])) {
        $syntax = $_POST['syntax'];
} else if (isset($argv) && count($argv) > 2) {
        $syntax = $argv[1];
}

if ($syntax === '') die();

if (isset($_POST['input'])) {
        $input = $_POST['input'];
} else if (isset($argv) && count($argv) > 2) {
        $input = $argv[2];
}

if ($input === '') die();

switch($syntax) {
case 'javascript':
        $output = '<script>'.$input.'</script>';
        break;
default:
        $output = $input;
        break;
}

header("X-XSS-Protection: 0");
echo $output . "\n";

?>
