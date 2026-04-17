<?php

class HomeController extends Controller {

    public function index() {
        $this->view('home/index');
    }

    public function about() {
        $this->view('home/about');
    }
}