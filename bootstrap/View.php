<?php


namespace core;

use RuntimeException;

trait View {
    /**
     * @throws RuntimeException
     */
    public function render($view, $params = []) {
        $position = strpos($view, ".");
        if ($position) {
            $view = str_replace(".", "/", $view);
        }

        if (is_readable(APP_ROOT . "/src/views/$view.php")) {
            return $this->generateView($view, $params);
        }

        throw new RuntimeException("404 PAGE NOT FOUND", 404);
    }

    private function generateView($view, $params): bool {
        foreach ($params as $key => $value) {
            $$key = $value;
        }

        ob_start();
        require_once APP_ROOT . "/src/views/$view.php";
        echo ob_get_clean();
        return true;
    }
}