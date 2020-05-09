<?php

namespace Camagru\Service;

class EmailGenerator {

    const FROM = "noreply@camagru.com";
    private $_template;
    
    public function __construct($template)
    {
        $this->_template = 'src/View/Email/' . $template . '.php';
    }

    public function generate(array $data)
    {
        if (\file_exists($this->_template)) {
            \extract($data);
            \ob_start();
            require $this->_template;
            return array(
                'email' => \ob_get_clean(),
                'subject' => $subject
            );
        }
        else {
            throw new \Exception('Fichier '.$this->_template.' Introuvable');
        }
    }

}