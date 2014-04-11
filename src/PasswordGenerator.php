<?php
namespace Icecave\Abraxas;

use Rych\Random\Random;

/**
 * A basic password generator that generates passwords using alphanumeric
 * characters and punctuation.
 */
class PasswordGenerator implements PasswordGeneratorInterface
{
    public function __construct(Random $rng = null)
    {
        if (null === $rng) {
            $rng = new Random;
        }

        $this->rng = $rng;
    }
    /**
     * Fetch the minimum length of generated passwords.
     *
     * @return integer The minimum length of generated passwords.
     */
    public function minimumLength()
    {
        return $this->minimumLength;
    }

    /**
     * Set the minimum length of generated passwords.
     *
     * @param integer $length The minimum length of generated passwords.
     */
    public function setMinimumLength($length)
    {
        $this->minimumLength = $length;
    }

    /**
     * Fetch the maximum length of generated passwords.
     *
     * @return integer The maximum length of generated passwords.
     */
    public function maximumLength()
    {
        return $this->maximumLength;
    }

    /**
     * Set the maximum length of generated passwords.
     *
     * @param integer $length The maximum length of generated passwords.
     */
    public function setMaximumLength($length)
    {
        $this->maximumLength = $length;
    }

    /**
     * Indicates whether or not generated passwords may contain uppercase
     * characters.
     *
     * @return boolean True if uppercase characters are allowed.
     */
    public function allowUppercase()
    {
        return $this->allowUppercase;
    }

    /**
     * Set whether or not generated passwords may contain symbols.
     *
     * @param boolean $allow True if uppercase characters are allowed.
     */
    public function setAllowUppercase($allow)
    {
        $this->allowUppercase = $allow;
        $this->characterSet = null;
    }

    /**
     * Indicates whether or not generated passwords may contain digits.
     *
     * @return boolean True if digits are allowed.
     */
    public function allowDigits()
    {
        return $this->allowDigits;
    }

    /**
     * Set whether or not generated passwords may contain symbols.
     *
     * @param boolean $allow True if digits are allowed.
     */
    public function setAllowDigits($allow)
    {
        $this->allowDigits = $allow;
        $this->characterSet = null;
    }

    /**
     * Indicates whether or not generated passwords may contain symbols.
     *
     * The allowed symbols are:
     *    ` ~ ! @ # $ % ^ & * ( ) _ + - = { } [ ] < > , . / ? ; : ' " \ |
     *
     * @return boolean True if symbols are allowed.
     */
    public function allowSymbols()
    {
        return $this->allowSymbols;
    }

    /**
     * Set whether or not generated passwords may contain symbols.
     *
     * @param boolean $allow True if symbols are allowed.
     */
    public function setAllowSymbols($allow)
    {
        $this->allowSymbols = $allow;
        $this->characterSet = null;
    }

    /**
     * Indicates whether or not generated passwords may ambiguous characters.
     *
     * The following characters are considered to be potentially ambiguous:
     *    B 8 G 6 I 1 l 0 O Q D S 5 Z 2
     *
     * @return boolean True if ambiguous characters are allowed.
     */
    public function allowAmbiguousCharacters()
    {
        return $this->allowAmbiguousCharacters;
    }

    /**
     * Set whether or not generated passwords may ambiguous characters.
     *
     * @param boolean $allow True if ambiguous characters are allowed.
     */
    public function setAllowAmbiguousCharacters($allow)
    {
        $this->allowAmbiguousCharacters = $allow;
        $this->characterSet = null;
    }

    /**
     * Generate a password.
     *
     * @return string The generated password.
     */
    public function generate()
    {
        $length = $this->rng->getRandomInteger(
            $this->minimumLength(),
            $this->maximumLength()
        );

        $password = '';
        $characterSet = $this->characterSet();
        $maxIndex = strlen($characterSet) - 1;

        for ($i = 0; $i < $length; ++$i) {
            $password .= $characterSet[
                $this->rng->getRandomInteger(0, $maxIndex)
            ];
        }

        return $password;
    }

    /**
     * Fetch the character set used when generating passwords.
     *
     * @return string The character set.
     */
    public function characterSet()
    {
        if (null === $this->characterSet) {
            $this->characterSet = 'abcdefghijklmnopqrstuvwxyz';

            if ($this->allowUppercase()) {
                $this->characterSet .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            }

            if ($this->allowDigits()) {
                $this->characterSet .= '0123456789';
            }

            if ($this->allowSymbols()) {
                $this->characterSet .= '`~!@#$%^&*()_+-={}[]<>,./?;:\'"\\|';
            }

            if (!$this->allowAmbiguousCharacters()) {
                $this->characterSet = preg_replace(
                    '/[B8G6I1l0OQDS5Z2]/',
                    '',
                    $this->characterSet
                );
            }
        }

        return $this->characterSet;
    }

    private $minimumLength = 8;
    private $maximumLength = 12;
    private $allowUppercase = true;
    private $allowDigits = true;
    private $allowSymbols = true;
    private $allowAmbiguousCharacters = true;
    private $characterSet = null;
    private $rng;
}
