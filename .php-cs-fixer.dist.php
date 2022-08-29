<?php

declare(strict_types=1);

$finder = Symfony\Component\Finder\Finder::create()
    ->in([
        __DIR__ . '/src',
        __DIR__ . '/tests',
    ])
    ->name('*.php')
    ->notName('*.blade.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR12' => true,
        '@PSR12:risky' => true,

        // clean code
        'ordered_imports' => ['sort_algorithm' => 'alpha', 'imports_order' => [
            'class',
            'function',
            'const',
        ]],
        'no_empty_statement' => true,
        'no_unneeded_control_parentheses' => true,
        'no_unneeded_curly_braces' => true,
        // strict
        'declare_strict_types' => true,
        'is_null' => true,
        'strict_comparison' => true,
        'strict_param' => true,
        // namespaces
        'single_blank_line_before_namespace' => true,
        // imports
        'global_namespace_import' => [
            'import_classes' => true,
            'import_constants' => null,
            'import_functions' => null,
        ],
        'no_unused_imports' => true,

        // array
        'no_whitespace_before_comma_in_array' => true,
        'array_indentation' => true,
        'trim_array_spaces' => true,
        'whitespace_after_comma_in_array' => true,
        // array commas
        'trailing_comma_in_multiline' => ['elements' => ['arrays'], 'after_heredoc' => true],
        'no_trailing_comma_in_singleline_array' => true,
        'array_syntax' => ['syntax' => 'short'],
        // control structures
        'function_to_constant' => true,
        'explicit_string_variable' => true,
        'explicit_indirect_variable' => true,
        'single_class_element_per_statement' => ['elements' => ['const', 'property']],
        'new_with_braces' => true,
        'class_definition' => ['single_line' => true],
        'standardize_increment' => true,
        'magic_constant_casing' => true,
        'no_useless_else' => true,
        'single_quote' => true,
        'yoda_style' => ['equal' => \false, 'identical' => \false, 'less_and_greater' => \false],
        'ordered_class_elements' => true,
        // espacios y líneas en blanco
        'binary_operator_spaces' => ['operators' => ['=>' => 'single_space']],
        'blank_line_after_opening_tag' => true,
        'blank_line_before_statement' => ['statements' => [
            'break',
            'continue',
            'declare',
            'return',
            'throw',
            'try',
        ]],
        'cast_spaces' => true,
        'class_attributes_separation' => true,
        'concat_space' => ['spacing' => 'one'],
        'function_typehint_space' => true,
        'method_argument_space' => ['on_multiline' => 'ensure_fully_multiline', 'keep_multiple_spaces_after_comma' => true, 'after_heredoc' => true],
        'method_chaining_indentation' => true,
        'no_blank_lines_after_class_opening' => true,
        'no_leading_namespace_whitespace' => true,
        'no_multiline_whitespace_around_double_arrow' => true,
        'no_singleline_whitespace_before_semicolons' => true,
        'no_space_around_double_colon' => true,
        'no_spaces_around_offset' => true,
        'no_whitespace_in_blank_line' => true,
        'not_operator_with_successor_space' => true,
        'operator_linebreak' => true,
        'object_operator_without_whitespace' => true,
        'return_type_declaration' => true,
        'single_space_after_construct' => true,
        'single_trait_insert_per_statement' => true,
        'space_after_semicolon' => true,
        'ternary_operator_spaces' => true,
        'types_spaces' => true,
        'unary_operator_spaces' => true,
        // strings
        'escape_implicit_backslashes' => true,
        'simple_to_complex_string_variable' => true,
        // docblock
        'align_multiline_comment' => true,
        'doctrine_annotation_spaces' => true,
        'multiline_comment_opening_closing' => true,
        'no_empty_phpdoc' => true,
        'no_superfluous_phpdoc_tags' => ['remove_inheritdoc' => true, 'allow_mixed' => true],
        'no_trailing_whitespace_in_comment' => true,
        'phpdoc_indent' => true,
        'phpdoc_line_span' => ['const' => 'single', 'property' => 'single'],
        'phpdoc_no_empty_return' => true,
        'phpdoc_order' => true,
        'phpdoc_return_self_reference' => true,
        'phpdoc_scalar' => true,
        'phpdoc_single_line_var_spacing' => true,
        'phpdoc_trim' => true,
        'phpdoc_trim_consecutive_blank_line_separation' => true,
        'phpdoc_types' => true,
        'phpdoc_types_order' => ['null_adjustment' => 'always_last', 'sort_algorithm' => 'none'],
        'phpdoc_var_annotation_correct_order' => true,
        'phpdoc_var_without_name' => true,
        'single_line_comment_style' => ['comment_types' => ['hash']],
        // phpunit
        'php_unit_fqcn_annotation' => true,
        'php_unit_method_casing' => ['case' => 'snake_case'],
        'php_unit_no_expectation_annotation' => true,


        /**
         * Otros reemplazos de código
         */
        'assign_null_coalescing_to_coalesce_equal' => true,
        'ereg_to_preg' => true,
        'lambda_not_used_import' => true,
        'magic_method_casing' => true,
        'native_function_casing' => true,
        'native_function_type_declaration_casing' => true,
        'no_alias_functions' => ['sets' => ['@all']],
        'no_unset_cast' => true,
        'no_useless_return' => true,
        'random_api_migration' => ['replacements' => ['getrandmax' => 'mt_getrandmax', 'rand' => 'random_int', 'srand' => 'random_int']],
        'return_assignment' => true,
        'set_type_to_cast' => true,
        'simplified_null_return' => true,
        'standardize_not_equals' => true,
        'ternary_to_elvis_operator' => true,
        'ternary_to_null_coalescing' => true,
    ])
    ->setRiskyAllowed(true)
    ->setFinder($finder);
