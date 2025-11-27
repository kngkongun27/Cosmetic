<?php

if (!function_exists('format_price')) {
    function format_price($number)
    {
        // Nếu nhỏ hơn 1000 thì nhân 1000 để hiển thị nghìn đồng
        if ($number < 1000) {
            $number *= 1000;
        }

        return number_format($number, 0, ',', '.') . 'đ';
    }
}
