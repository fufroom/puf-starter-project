<?php

namespace Puf\Core;

require __DIR__ . '/vendor/autoload.php';
use Mustache_Engine;

class Templating
{
    private $mustache;

    public function __construct()
    {
        $partials = [];
        $srcPath = realpath(__DIR__ . "/..");

        if ($srcPath) {
            foreach (glob("$srcPath/*.hbs") as $file) {
                $name = basename($file, ".hbs");
                $partials[$name] = file_get_contents($file);
            }
        }

        $this->mustache = new Mustache_Engine([
            'partials' => $partials
        ]);
    }

    public function render($template, $data)
    {
        $templateFile = __DIR__ . "/../$template.hbs";

        if (!file_exists($templateFile)) {
            throw new \Exception("Template file '$template.hbs' not found");
        }

        $templateContent = file_get_contents($templateFile);

        return $this->mustache->render($templateContent, $data);
    }
}
