<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Email_Model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function sendmail($to,$subject,$message)
    {
        $config = Array(  
            'protocol' => 'smtp',  
            'smtp_host' => 'ssl://srv36.niagahoster.com',  
            'smtp_port' => 465,    
            'smtp_user' => 'info@limitcode.xyz',   
            'smtp_pass' => 'rahasia',   
            'mailtype' => 'html',   
            'starttls'  => TRUE,
            'newline'   => "\r\n",
            'wordwrap' => TRUE
        );  

        $this->load->library('email', $config);  
        $this->email->set_newline("\r\n");  
        $this->email->from('info@limitcode.xyz', 'Limit Code Info');   
        $this->email->to("$to");   
        $this->email->subject("$subject");   
        $this->email->message("$message");  
        if (!$this->email->send()) {  
            echo $this->email->print_debugger(); exit();
            // $send_status = 'failed';
        } else {  
            $send_status = 'sended';
        }  

        $send_datetime = date('Y-m-d H:i:s');


        $sql = "INSERT INTO email_tb(send_to,mail_subject,mail_message,send_datetime,send_status) "
        . "VALUES("
        . "" . $this->db->escape($to) . ", "
        . "" . $this->db->escape($subject) . ", "
        . "" . $this->db->escape($message) . ", "
        . "" . $this->db->escape($send_datetime) . ", "
        . "" . $this->db->escape($send_status) . ")";
        $this->db->query($sql);
        
        if($this->db->affected_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function emailBody($for,$url,$because)
    {
        if(isset($for)) {
            if($for == 'successregister') {
                $bodyBanner = 'thanks.jpg';
                $bodySubject = 'You just registered in Limit Code';
                $bodyMeans = 'Please click the link below to verify your email';
                $bodyButton = 'blue';
                $bodyUrl = base_url().index_with().$url;
                $bodyButtonValue = 'Verify';

            } elseif($for == 'rejectcontent') {
                $bodyBanner = 'sorry.jpg';
                $bodySubject = 'You content has been reject';
                $bodyMeans = 'Because '.$because;
                $bodyButton = 'red';
                $bodyUrl = base_url().index_with().$url;
                $bodyButtonValue = 'Verify';

            } elseif($for == 'publishcontent') {
                $bodyBanner = 'welldone.jpg';
                $bodySubject = 'You content has been publish in Limit Code';
                $bodyMeans = 'Click link below to see '.$because;
                $bodyButton = 'green';
                $bodyUrl = $url;
                $bodyButtonValue = 'My Content';

            } elseif($for == 'blockcontent') {
                $bodyBanner = 'sorry.jpg';
                $bodySubject = 'You content has been rejected';
                $bodyMeans = 'Your content '.$because.' has beend rejected by Limit Code';
                $bodyButton = 'orange';
                $bodyUrl = base_url().index_with().$url;
                $bodyButtonValue = 'Verify';

            } elseif($for == 'unblockcontent') {
                $bodyBanner = 'welldone.jpg';
                $bodySubject = 'You content has been unblocked';
                $bodyMeans = 'Click link below to see '.$because;
                $bodyButton = 'green';
                $bodyUrl = base_url().index_with().$url;
                $bodyButtonValue = 'My Content';

            } elseif($for == 'resetpassword') {
                $bodyBanner = 'welldone.jpg';
                $bodySubject = 'You password has beend reset';
                $bodyMeans = 'Click link below for create new password';
                $bodyButton = 'green';
                $bodyUrl = base_url().index_with().$url;
                $bodyButtonValue = 'Reset Password';

            } else {
                $bodyBanner = 'thanks.jpg';
                $bodySubject = 'Error Message';
                $bodyMeans = 'Error Message';
                $bodyButton = 'btn btn-info';
                $bodyUrl = base_url().index_with().$url;
                $bodyButtonValue = 'Error Message';
            }
        }
        
        $email = '<!DOCTYPE html>
        <html>
        <head>
        <title>LIMIT CODE EMAIL</title>
        <style>
        .green {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
        }

        .red {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
        }

        .orange {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
        }

        .blue {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 15px 32px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
        }
        </style>
        </head>
        <body>
        <center>
        <img src="'.base_url().'layout/img/email/'.$bodyBanner.'" class="img img-responsive">
        <hr>
        <h1>'.$bodySubject.'</h1>
        <h2>'.$bodyMeans.'</h2>
        <a class="'.$bodyButton.'" href="'.$bodyUrl.'">'.$bodyButtonValue.'</a>
        <hr>
        <img style="width: 300px" src="'.base_url().'/layout/img/email/lc-logo.jpg" class="img img-responsive">
        </center>
        </body>
        </html>';

        return $email;
    }
}
