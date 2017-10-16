<?php

namespace TodoList\Libs;

/**
 * Class View - Responsible for rendering app templates
 * @package TodoList\Libs
 */
class View {

    /**
     * Render view tamplate
     * @param string $template Template to render
     */
    public function render($template) {
        include_once BASE_PATH . 'views/public/partials/header.php';
        include_once BASE_PATH . 'views/public/partials/error_messages.php';
        include_once BASE_PATH . 'views/public/'.$template;
        include_once BASE_PATH . 'views/public/partials/footer.php';
    }

    /**
     * Translate url with Serbian letters
     * @param string $name
     * @return mixed|string
     */
    public function urlName($name) {
        $trans = array( "ć" => "c", "č" => "c", "š" => "s", "ž" => "z", "š" => "s",
                        "Ć" => "c", "Č" => "c", "Š" => "s", "Ž" => "z", "Š" => "s",
                        " " => "-", "/" => "-"
        );

        $name = strtr($name, $trans);
        $name = preg_replace('/[^A-Za-z0-9\-]/', '', $name);
        $name = strtolower($name);
        return $name;
    }

}