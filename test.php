<?php
$file = __DIR__ . '/bootstrap/cache/test_write.txt';
if (file_put_contents($file, 'test') !== false) {
    echo "✅ Ghi được vào cache";
} else {
    echo "❌ Không ghi được vào cache";
}