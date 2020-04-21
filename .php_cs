<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->exclude([
        'var',
        'vendor'
    ]);

return PhpCsFixer\Config::create()
    ->setRiskyAllowed(true)
    ->setRules([
        '@PHP71Migration' => true,
        '@PSR1' => true,
        '@PSR2' => true,
        'align_multiline_comment' => true,
        'array_syntax' => ['syntax' => 'short'],
        'blank_line_before_statement' => [
            'statements' => ['return'],
        ],
        'linebreak_after_opening_tag' => true,
        'list_syntax' => ['syntax' => 'short'],
        'modernize_types_casting' => true,
        'no_leading_namespace_whitespace' => true,
        'no_multiline_whitespace_before_semicolons' => true,
        'no_php4_constructor' => true,
        'no_short_echo_tag' => true,
        'no_unused_imports' => true,
        'no_useless_else' => true,
        'no_useless_return' => true,
        'no_whitespace_in_blank_line' => true,
        'ordered_class_elements' => true,
        'ordered_imports' => true,
        'psr4' => true,
        'semicolon_after_instruction' => true,
        'single_line_comment_style' => true,
        'trailing_comma_in_multiline_array' => true,
        'trim_array_spaces' => true,
    ])
    ->setCacheFile(__DIR__.'/.php_cs.cache')
    ->setFinder($finder);
