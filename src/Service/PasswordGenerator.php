<?php

namespace Camagru\Service;

class PasswordGenerator {

    public function generate(
        int $length = 10,
        string $keychain = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ?!*@"
        )
    {
        $password = "";
        $max = strlen($keychain) - 1;
        $i = -1;
        while (++$i < $length) {
            $password .= $keychain[random_int(0, $max)];
        }

        return $password;
    }

}