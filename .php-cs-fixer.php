<?php

$finder = (new PhpCsFixer\Finder())
    ->in(__DIR__)
    ->exclude([
        'var',
        'src/Domain/Model'
    ]);

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12' => true,
        'array_syntax' => ['syntax' => 'short'],
        'void_return' => true,
        'trailing_comma_in_multiline' => true,
        'no_trailing_comma_in_singleline_array' => true,
        'trim_array_spaces' => true,
        'single_quote' => true,
        'method_chaining_indentation' => true,
        'yoda_style' => true,
        'set_type_to_cast' => true,
        'final_class' => true,
        'protected_to_private' => true,
        'date_time_immutable' => true,
        'ordered_imports' => true,
        'logical_operators' => true,
        'assign_null_coalescing_to_coalesce_equal' => true,
        'no_closing_tag' => true,
        'declare_strict_types' => true,
        'compact_nullable_typehint' => true,
        'class_attributes_separation' => [
            'elements' => [
                'const' => 'none',
                'method' => 'one',
                'property' => 'none',
                'trait_import' => 'none',
                'case' => 'none'
            ]
        ],
        'ordered_class_elements' => [
            'order' => [
                'use_trait',
                'case',
                'constant_public',
                'constant_protected',
                'constant_private',
                'property_public',
                'property_protected',
                'property_private',
                'construct',
                'destruct',
                'method_public',
                'method_protected',
                'method_private',
                'magic',
            ]
        ]
    ])
    ->setFinder($finder);
