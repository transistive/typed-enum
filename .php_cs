<?php

declare(strict_types=1);

/*
 * This file is part of the Laudis TypedEnum library
 *
 * (c) Laudis <https://laudis.tech>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$header = <<<'EOF'
This file is part of the Laudis TypedEnum library

(c) Laudis <https://laudis.tech>

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
EOF;

$finder = Finder::create()
    ->in(__DIR__.'/src/')
    ->in(__DIR__.'/tests/')
;

return Config::create()
    ->setRules([
        '@Symfony' => true,
        '@PhpCsFixer' => true,
        '@Symfony:risky' => true,
        '@PhpCsFixer:risky' => true,
        '@PHP73Migration' => true,
        'backtick_to_shell_exec' => true,
        'date_time_immutable' => true,
        'declare_strict_types' => true,
        'phpdoc_to_param_type' => false,
        'phpdoc_to_return_type' => false,
        'random_api_migration' => true,
        'static_lambda' => true,
        'yoda_style' => false,

        'array_syntax' => ['syntax' => 'short'],
        'header_comment' => ['header' => $header],
        'linebreak_after_opening_tag' => true,
        'ordered_imports' => true,
        'phpdoc_order' => true,
        'no_superfluous_phpdoc_tags' => true,
        'no_superfluous_elseif' => true,
        'heredoc_indentation' => false,
        'native_function_invocation' => false,

        'modernize_types_casting' => true,
        'no_useless_return' => true,
        'strict_param' => true,
        'php_unit_strict' => false,
    ])
    ->setFinder($finder)
;
