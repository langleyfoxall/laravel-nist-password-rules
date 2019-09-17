<?php

$file = __DIR__.'/../../resources/sequential_passwords.txt';

$fh = fopen($file, 'w');

for ($amount = 1; $amount < 59; $amount++) {
    for ($charCode = 32; $charCode <= 126; $charCode++) {
        $password = '';
        for ($offset = 0; $offset <= $amount; $offset++) {
            if ($charCode + $offset >= 127 || $charCode + $offset < 32) {
                continue 2;
            }
            $password .= chr($charCode + $offset);
        }
        fwrite($fh, $password.PHP_EOL);
    }
}

for ($amount = 59; $amount > 0; $amount--) {
    for ($charCode = 126; $charCode >= 0; $charCode--) {
        $password = '';
        for ($offset = $amount; $offset > 0; $offset--) {
            if ($charCode + $offset >= 127 || $charCode + $offset < 32) {
                continue 2;
            }
            $password .= chr($charCode + $offset);
        }
        fwrite($fh, $password.PHP_EOL);
    }
}

fclose($fh);
