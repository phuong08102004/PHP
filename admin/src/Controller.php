<?php
namespace App;

class Controller
{
    protected function render($view, $data = [])
    {
        extract($data);

        ob_start();
        require __DIR__ . '/Views/' . $view . '.php';
        $content = ob_get_clean();

        require __DIR__ . '/../templates/layout.php';
    }
}
