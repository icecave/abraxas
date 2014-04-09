<?php
namespace Icecave\Abraxas;

/**
 * Interface for password generators.
 */
interface PasswordGeneratorInterface
{
    /**
     * Generate a password.
     *
     * @return string The generated password.
     */
    public function generate();

    /**
     * Fetch the minimum length of generated passwords.
     *
     * @return integer The minimum length of generated passwords.
     */
    public function minimumLength();

    /**
     * Set the minimum length of generated passwords.
     *
     * @param integer $length The minimum length of generated passwords.
     */
    public function setMinimumLength($length);

    /**
     * Fetch the maximum length of generated passwords.
     *
     * @return integer The maximum length of generated passwords.
     */
    public function maximumLength();

    /**
     * Set the maximum length of generated passwords.
     *
     * @param integer $length The maximum length of generated passwords.
     */
    public function setMaximumLength($length);
}
