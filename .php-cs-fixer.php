<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__.'/src')
    ->in(__DIR__.'/tests')
    ;

$config = new PhpCsFixer\Config();

return $config
    ->setRules([
        '@PSR2' => true,
        '@PSR1' => true,
        '@PSR12' => true,
        '@PhpCsFixer' => true,
        '@PHP71Migration' => true,
        'array_syntax' => ['syntax' => 'short'],
        'binary_operator_spaces' => ['default' => 'single_space', 'operators' => ['=>' => 'align']],
    ])
    ->setFinder($finder)
;
