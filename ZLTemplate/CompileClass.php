<?php

class CompileClass
{
    private $template;
    private $content;
    private $comfile;
    private $left = '{';
    private $right = '}';
    private $value = array();

    public function __construct()
    {
    }

    public function compile($source, $destFile)
    {
        file_put_contents($destFile, file_get_contents($source));
    }
}
