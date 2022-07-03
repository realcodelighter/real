<?php

namespace Response;

class Home extends \CodeLighter\Controller
{
    function __construct()
    {
        $this->Home = $this->model('Home');
    }
    
    function login()
    {
        $this->Home->set([
            ['username', 'clean'],
            ['password', 'md6']
        ]);
        $this->json(
            $this->Home->login()
        );
    }
}
