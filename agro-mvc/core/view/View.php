<?php 

namespace core\view;

class View
{
    public static function render(
        string $file_name, 
        ?array $matches
        ) 
    {
        $path_html = current(array_filter(
            glob('./assets/html/*.html'),
            function ($file_path) use ($file_name) {
                return preg_match("/{$file_name}/", $file_path) != false;      
            }));

        $html = file_get_contents($path_html);
    }
}