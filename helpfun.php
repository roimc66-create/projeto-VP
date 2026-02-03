<?php
if (!function_exists('e')) {
    function e($v) {
        return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('dinheiro')) {
    function dinheiro($v) {
        $num = is_numeric($v) ? (float)$v : 0;
        return number_format($num, 2, ',', '.');
    }
}
