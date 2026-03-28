<?php

declare(strict_types=1);

namespace StructuraPhp\StructuraPhpunit;

use PHPUnit\Framework\Assert;
use StructuraPhp\Structura\Builder\AllClasses;
use StructuraPhp\Structura\Builder\RuleBuilder;
use StructuraPhp\Structura\Expr;
use StructuraPhp\Structura\ExprScript;
use StructuraPhp\Structura\Services\ExecuteService;

trait ArchitectureAsserts
{
    /**
     * @return AllClasses<Expr>
     */
    final protected function allClasses(): AllClasses
    {
        return AllClasses::allClasses();
    }

    /**
     * @return AllClasses<ExprScript>
     */
    final protected function allScripts(): AllClasses
    {
        return AllClasses::allScripts();
    }

    /**
     * @no-named-arguments
     */
    final protected static function assertRules(RuleBuilder $ruleBuilder): void
    {
        $executeService = new ExecuteService($ruleBuilder->getRuleObject());
        $assert = $executeService->assert()->getAssertValueObject();

        foreach ($assert->pass as $key => $value) {
            Assert::assertTrue(
                (bool) $value,
                implode(', ', $assert->violations[$key] ?? []),
            );
        }
    }
}
