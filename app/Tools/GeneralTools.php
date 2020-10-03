<?php


namespace App\Tools;


class GeneralTools
{
    // convert markdown to html
    public static function convert_markdown_to_html($content) {
        $parser = new \Parsedown();
        $parser->setSafeMode(true);
        return $parser->parse($content);
    }
}
