# Structura PHPUnit

[PHPUnit](https://phpunit.de/index.html) extension for Structura

## Requirements

### PHP version

| PHPUnit Version | PHP Version     | Structura 0.x |
|-----------------|-----------------|---------------|
| <= 10.x         | <= 8.1          | ✗ Unsupported |
| 11.x / 12.x     | 8.2 / 8.3 / 8.4 | ✓ Supported   |

## Installation

### Using Composer

```shell
composer required --dev structuraphp/structura-phpunit
```

## Usage

Here's an example of an architecture test for Laravel's HTTP scope:

```php
<?php

declare(strict_types=1);

namespace Tests\Architecture;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Resources\Json\JsonResource;
use PHPUnit\Framework\TestCase;
use Structura\Expr;
use StructuraPhp\StructuraPhpunit\ArchitectureAsserts;

final class ArchitectureHttpTest extends TestCase
{
    use ArchitectureAsserts;
    
    private static string $dir;
    
    public static function setUpBeforeClass(): void
    {
        self::$dir = dirname(__DIR__, 2).'/app/Http';
    }

    public function testHttpRequestsArchitecture(): void
    {
        $rules = $this
            ->allClasses()
            ->fromDir(self::$dir.'/Requests')
            ->should(
                static fn(Expr $assert): Expr => $assert
                    ->toExtend(FormRequest::class)
                    ->toHaveSuffix('Request')
                    ->or(static fn(Expr $assert) => $assert
                        ->toHaveMethod('attributes')
                        ->toHaveMethod('messages')
                    ),
            );

        self::assertRules($rules);
    }

    public function testHttpControllersArchitecture(): void
    {
        $rules = $this
            ->allClasses()
            ->fromDir(self::$dir.'/Controllers')
            ->should(
                static fn(Expr $assert): Expr => $assert
                    ->toExtend(Controller::class)
                    ->toBeFinal()
                    ->toHaveSuffix('Controller'),
            );

        self::assertRules($rules);
    }

    public function testHttpResourcesArchitecture(): void
    {
        $rules = $this
            ->allClasses()
            ->fromDir(self::$dir.'/Resources')
            ->should(
                static fn(Expr $assert): Expr => $assert
                    ->toExtend(JsonResource::class)
                    ->toBeFinal()
                    ->toHaveSuffix('Resources')
                    ->toHaveMethod('toArray'),
            );

        self::assertRules($rules);
    }
}
```

Then run your PHPUnit tests with the following command:

```bash
vendor/bin/phpunit --filter=Architecture
```