<?php

namespace Controllers;

class Home extends \CodeLighter\Controller
{
    function __construct()
    {
        $this->Home = $this->model('Home');

        $this->data = [
            'title' => "Awesome framework",
            'style' => ['home'],
            'script' => ['home'],
        ];
    }
    function index()
    {
        return $this->view();
    }
}
