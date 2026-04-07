<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LoadAssets {

    public function start_buffer()
    {
        ob_start(array($this, 'modify_output'));
    }

    public function modify_output($buffer)
    {
        $css = '<link rel="stylesheet" href="' . base_url('assets/css/custom.css') . '">' . PHP_EOL;

        // Only inject if </head> exists
        if (strpos($buffer, '</head>') !== false) {
            $buffer = str_replace('</head>', $css . '</head>', $buffer);
        }

        return $buffer;
    }
}
