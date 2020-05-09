<?php

namespace Camagru\Service;

use Camagru\Service\EmailTemplate;

class Emailer {

    const FROM = "noreply@camagru.com";
    private $_recipient;
    private $_emailGenerator;
    private $_email;
    private $_subject;

    public function setRecipient(string $recipient)
    {
        $this->_recipient = $recipient;
    }

    public function setEmailTemplate(string $templateName)
    {
        $this->_emailGenerator = new EmailGenerator($templateName);
    }

    public function generateEmail(array $data)
    {
        $array = $this->_emailGenerator->generate($data);
        $this->_subject = $array['subject'];
        $this->_email = $array['email'];
    }

    public function send()
    {
        $headers = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= "MIME-Version: 1.0" . "\n";

        try {
            mail($this->_recipient, $this->_subject, $this->_email, $headers);
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

}