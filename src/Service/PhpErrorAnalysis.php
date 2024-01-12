<?php

namespace App\Service;

use PhpParser\ParserFactory;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;
use PhpParser\Parser\Php8;
use PhpParser\PhpVersion;

class PhpErrorAnalysis
{
    private $parser;

    public function __construct(ParserFactory $parserFactory)
    {
        //$this->parser = $parserFactory->create(PhpVersion::PHP7);
    }

    public function analyzeCode(string $code)
    {
    }
}
