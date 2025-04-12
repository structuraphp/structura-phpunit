<?php

declare(strict_types=1);

namespace StructuraPhp\StructuraPhpunit\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Structura\Except;
use Structura\Expr;
use StructuraPhp\StructuraPhpunit\ArchitectureAsserts;

class ArchitectureAssertTest extends TestCase
{
    use ArchitectureAsserts;

    public function testArchitectureAssert(): void
    {
        $rules = $this
            ->allClasses()
            ->fromRaw('<?php abstract class Foo {}')
            ->should(
                static fn(Expr $assert): Expr => $assert->toBeAbstract(),
            );

        self::assertRules($rules);
    }
}
