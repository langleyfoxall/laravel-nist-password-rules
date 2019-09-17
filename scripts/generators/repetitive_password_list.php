<?php

$file = __DIR__.'/../../resources/repetitive_passwords.txt';

$fh = fopen($file, 'w');

for ($charCode = 32; $charCode <= 126; $charCode++) {
    for ($amount = 1; $amount < 60; $amount++) {
        $password = str_repeat(chr($charCode), $amount);
        fwrite($fh, $password.PHP_EOL);
    }
}

fclose($fh);
