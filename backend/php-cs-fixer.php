<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->name('*.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

return (new PhpCsFixer\Config())
    ->setRiskyAllowed(false)
    ->setIndent("\t")
    ->setRules([
        '@PSR12' => true,
        'braces_position' => [
            'classes_opening_brace' => 'next_line_unless_newline_at_signature_end',
        ],
    ])
    ->setFinder($finder);
