<?php

$file = __DIR__.'/../../resources/sequential_passwords.txt';

$fh = fopen($file, 'w');

for ($amount = 1; $amount < 59; $amount++) {
    for ($charCode = 32; $charCode <= 126; $charCode++) {
        $password = '';
        for ($offset = 0; $offset <= $amount; $offset++) {
            if ($charCode+$offset >= 127) {
                continue 2;
            }
            $password .= chr($charCode+$offset);
        }
        fwrite($fh, $password . PHP_EOL);
    }
}

fclose($fh);
