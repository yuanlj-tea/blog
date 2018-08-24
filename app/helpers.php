<?php
if (!function_exists('p')) {
    function p($arr, $code = 0)
    {
        echo '<pre>';
        print_r($arr);
        echo '</pre>';
        if ($code == 1) {
            die;
        }
    }
}