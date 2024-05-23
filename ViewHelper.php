<?php

class ViewHelper
{
    public static function error404()
    {
        header('This page does not exist', true, 404);
        $h404 = "Error 404: Page not found."; // TODO: Nicer 404 page with a template
        echo $h404;
    }

    public static function render($file, $variables = array())
    {
        extract($variables);
        ob_start();
        include($file);
        $renderedHTML = ob_get_clean();
        echo $renderedHTML;
    }

    public static function redirect($url)
    {
        header("Location: " . $url);
    }
}
