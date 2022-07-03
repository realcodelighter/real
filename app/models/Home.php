<?php

namespace Model;

class Home extends \CodeLighter\Controller
{
    function __construct()
    {
        $this->DB = new \Helper\Database();
    }
    function CSRF()
    {
        return clean($_COOKIE['CSRF'] ?? 0);
    }
    function isLogin()
    {
        return $this->DB->check('SELECT id FROM sessions WHERE token = "' . $this->CSRF() . '"');
    }
    function login()
    {
        $p = $this->check([
            'username' => 'Unesite korisničko ime!',
            'password' => 'Unesite lozinku!',
        ]);
        if (count($p->_errors)) return [$p->_errors[0], $p->_fields[0]];

        $User = $this->DB->check('SELECT id FROM Users WHERE username = "' . $p->username . '" AND password = "' . $p->password . '"');
        if (!$this->DB->check('SELECT id FROM Users WHERE username = "' . $p->username . '"')) return 'Korisničko ime ne postoji!';
        if (!$User) return 'Neispravna lozinka!';

        $userAgent = $_SERVER['HTTP_USER_AGENT']; // change this to the useragent you want to parse
        $clientHints = \DeviceDetector\ClientHints::factory($_SERVER); // client hints are optional

        $dd = new \DeviceDetector\DeviceDetector($userAgent, $clientHints);
        $dd->skipBotDetection();
        $dd->parse();

        $osFamily = \DeviceDetector\Parser\OperatingSystem::getOsFamily($dd->getOs('name')) . ': ' . $dd->getBrandName() . ' ' . $dd->getModel();
        $browserFamily = \DeviceDetector\Parser\Client\Browser::getBrowserFamily($dd->getClient('name'));

        $this->DB->query('INSERT INTO sessions (user, token, os, browser, ip) VALUES ("' . $User . '", "' . $this->CSRF() . '", "' . $osFamily . '", "' . $browserFamily . '", "' . ip() . '")');

        return ["success" => "Uspešno!"];
    }
}
