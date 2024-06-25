<?php

namespace src\app\controllers;

use core\Request;

class HomeController {


    public function test(Request $request) {
        return view('home.home');
    }

}