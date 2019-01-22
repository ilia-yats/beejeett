<?php

namespace components;

use Twig_Loader_Filesystem;
use Twig_Environment;

class View
{
    private $twigEnv;

    public function __construct()
    {
        $loader = new Twig_Loader_Filesystem(APP_ROOT.'/views');
        $this->twigEnv = new Twig_Environment($loader, [
            'cache' => APP_ROOT.'/runtime/twig_cache',
        ]);
    }

    public function render(string $file, array $variables = []): string
    {
        $template = $this->twigEnv->load($file);

        return $template->render($variables);
    }
}