<?php
namespace Icecave\Abraxas;

use Phake;
use PHPUnit_Framework_TestCase;

class PasswordGeneratorTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->random = Phake::partialMock('Rych\Random\Random');
        $this->generator = new PasswordGenerator($this->random);
    }

    public function testMutatorsReturnThis()
    {
        $this->assertSame(
            $this->generator,
            $this->generator->setMinimumLength(10)
        );

        $this->assertSame(
            $this->generator,
            $this->generator->setMaximumLength(20)
        );

        $this->assertSame(
            $this->generator,
            $this->generator->setAllowUppercase(true)
        );

        $this->assertSame(
            $this->generator,
            $this->generator->setAllowDigits(true)
        );

        $this->assertSame(
            $this->generator,
            $this->generator->setAllowSymbols(true)
        );

        $this->assertSame(
            $this->generator,
            $this->generator->setAllowAmbiguousCharacters(true)
        );
    }

    public function testDefaultCharacterSet()
    {
        $this->assertSame(
            'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789`~!@#$%^&*()_+-={}[]<>,./?;:\'"\\|',
            $this->generator->characterSet()
        );
    }

    public function testAllowUppercase()
    {
        $this->generator->setAllowUppercase(false);

        $this->assertSame(
            'abcdefghijklmnopqrstuvwxyz0123456789`~!@#$%^&*()_+-={}[]<>,./?;:\'"\\|',
            $this->generator->characterSet()
        );
    }

    public function testAllowDigits()
    {
        $this->generator->setAllowDigits(false);

        $this->assertSame(
            'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ`~!@#$%^&*()_+-={}[]<>,./?;:\'"\\|',
            $this->generator->characterSet()
        );
    }

    public function testAllowSymbols()
    {
        $this->generator->setAllowSymbols(false);

        $this->assertSame(
            'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789',
            $this->generator->characterSet()
        );
    }

    public function testAllowAmbiguousCharacters()
    {
        $this->generator->setAllowAmbiguousCharacters(false);

        $this->assertSame(
            'abcdefghijkmnopqrstuvwxyzACEFHJKLMNPRTUVWXY3479`~!@#$%^&*()_+-={}[]<>,./?;:\'"\\|',
            $this->generator->characterSet()
        );
    }

    public function testGenerate()
    {
        Phake::when($this->random)
            ->getRandomInteger(Phake::anyParameters())
            ->thenReturn(10) // Length
            ->thenReturn(0)
            ->thenReturn(1)
            ->thenReturn(2)
            ->thenReturn(3)
            ->thenReturn(4)
            ->thenReturn(5)
            ->thenReturn(6)
            ->thenReturn(7)
            ->thenReturn(8)
            ->thenReturn(9);

        $password = $this->generator->generate();

        $this->assertSame(
            'abcdefghij',
            $password
        );

        $randomVerifier = Phake::verify(
            $this->random,
            Phake::times(10)
        )->getRandomInteger(0, 93);

        Phake::inOrder(
            Phake::verify($this->random)->getRandomInteger(8, 12),
            $randomVerifier,
            $randomVerifier,
            $randomVerifier,
            $randomVerifier,
            $randomVerifier,
            $randomVerifier,
            $randomVerifier,
            $randomVerifier,
            $randomVerifier,
            $randomVerifier
        );
    }

    public function testGenerateWithCustomLength()
    {
        $this->generator->setMinimumLength(4);
        $this->generator->setMaximumLength(6);

        Phake::when($this->random)
            ->getRandomInteger(Phake::anyParameters())
            ->thenReturn(5) // Length
            ->thenReturn(0)
            ->thenReturn(1)
            ->thenReturn(2)
            ->thenReturn(3)
            ->thenReturn(4)
            ->thenReturn(5)
            ->thenReturn(6)
            ->thenReturn(7)
            ->thenReturn(8)
            ->thenReturn(9);

        $password = $this->generator->generate();

        $this->assertSame(
            'abcde',
            $password
        );

        $randomVerifier = Phake::verify(
            $this->random,
            Phake::times(5)
        )->getRandomInteger(0, 93);

        Phake::inOrder(
            Phake::verify($this->random)->getRandomInteger(4, 6),
            $randomVerifier,
            $randomVerifier,
            $randomVerifier,
            $randomVerifier,
            $randomVerifier
        );
    }

    public function testGenerateFunctional()
    {
        $generator = new PasswordGenerator;
        $characterSet = $generator->characterSet();
        $pattern = '/^[' . preg_quote($characterSet, '/') . ']{8,12}$/';

        for ($i = 0; $i < 10; ++$i) {
            $this->assertRegExp($pattern, $generator->generate());
        }
    }
}
