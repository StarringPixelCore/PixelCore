<?php

namespace App\Services;

class EmailService
{
    protected $email;
    
    public function __construct()
    {
        $this->email = service('email');
    }
    
    public function sendVerificationEmail($user)
    {
        $message = "Hello, ".$user['firstname']." ".$user['lastname'].",<br><br>
        Welcome to FEU Tech's Equipment Management System. To complete your signup, please click the link below.<br><br>
        <a href=".base_url('users/verify/'.$user['verify_token']).">Click here to verify your account</a><br><br> - From FEU Institute of Technology";
        
        $this->email->setTo($user['email']);
        $this->email->setSubject('Account Verification');
        $this->email->setMessage($message);
        
        return $this->email->send();
    }

    public function sendPasswordResetEmail(array $user, string $token): bool
    {
        $resetUrl = base_url('reset-password/' . $token);

        $message = "Hello, ".$user['firstname']." ".$user['lastname'].",<br><br>
        We received a request to reset your password. Click the link below to choose a new password. This link will expire in 1 hour.<br><br>
        <a href=".$resetUrl.">Click here to reset your password</a><br><br>
        If you did not request this, please ignore this email.";

        $this->email->setTo($user['email']);
        $this->email->setSubject('Password Reset Request');
        $this->email->setMessage($message);

        return $this->email->send();
    }
    
}