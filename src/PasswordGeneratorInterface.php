<?php
namespace Icecave\Abraxas;

interface PasswordGeneratorInterface
{
    /**
     * Generate a password.
     *
     * @return string The generated password.
     */
    public function generate();
}
