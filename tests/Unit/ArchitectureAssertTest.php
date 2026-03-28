<?php

declare(strict_types=1);

namespace StructuraPhp\StructuraPhpunit\Tests\Unit;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use StructuraPhp\Structura\Expr;
use StructuraPhp\Structura\ExprScript;
use StructuraPhp\StructuraPhpunit\ArchitectureAsserts;

#[CoversClass(ArchitectureAsserts::class)]
final class ArchitectureAssertTest extends TestCase
{
    use ArchitectureAsserts;

    public function testArchitectureAllClasses(): void
    {
        $rules = $this
            ->allClasses()
            ->fromRaw('<?php abstract class Foo {}')
            ->should(
                static fn (Expr $assert): Expr => $assert->toBeAbstract(),
            );

        self::assertRules($rules);
    }

    public function testArchitectureAllScript(): void
    {
        $rules = $this
            ->allScripts()
            ->fromRaw('<?php declare(strict_types=1);')
            ->should(
                static fn (ExprScript $assert): ExprScript => $assert->toUseStrictTypes(),
            );

        self::assertRules($rules);
    }
}
