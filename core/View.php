<?php


namespace core;

trait View {

    public function render($view, $params = []) {
        $position = strpos($view, ".");
        if ($position) {
            $view = str_replace(".", "/", $view);
        }

        if (is_readable(APP_ROOT . "/src/views/$view.php")) {
            return $this->generateView($view, $params);
        }

        return view('shared.404');
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