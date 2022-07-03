<?php

namespace CodeLighter;

class Core
{
    static function init($data = [])
    {
        $url = isset($_GET['CodeLighter']) ? explode('/', filter_var(rtrim($_GET['CodeLighter'] ?? [], '/'), FILTER_SANITIZE_URL)) : [];
        foreach ($data['css'] as $css)
            Stylesheet::add($css[0], $css[1]);

        foreach ($data['js'] as $js)
            Javascript::add($js[0], $js[1]);

        $Controller = 'Home';
        $Method = 'index';
        $Folder = 'Controllers';
        if (isset($url[0]) && !empty($url[0])) {
            $Controller = ucwords($url[0]);
            unset($url[0]);
            if ($Controller == 'Api') {
                // $Folder = $Controller;
                $Folder = "Response";
                $Controller = ucwords($url[1]);
                unset($url[1]);
            }
            if (count($url)) {
                $Method = current($url);
                array_shift($url);
            }
        }
        $Controller = '\\' . $Folder . '\\' . $Controller;
        if (!class_exists($Controller)) {
            header('Content-Type: application/json'); 
            die(json_encode('Unknown 404 error.'));
        }
        $Controller =  new $Controller;
        if (!method_exists($Controller, $Method)) {
            header('Content-Type: application/json'); 
            die(json_encode('Unknown 404 error.'));
        }
        $params = $url ? array_values($url) : [];
        return call_user_func_array([$Controller, $Method], $params);
    }
}
