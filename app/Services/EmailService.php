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
        If you did not request this, please ignore this email.<br><br>
        - From FEU Institute of Technology";

        $this->email->setTo($user['email']);
        $this->email->setSubject('Password Reset Request');
        $this->email->setMessage($message);

        return $this->email->send();
    }

    public function sendBorrowConfirmationEmail(array $user, string $equipmentName, string $roomNumber, string $borrowDate, string $borrowTime, string $status = 'Pending'): bool
    {
        $formattedDate = date('M d, Y', strtotime($borrowDate));
        $formattedTime = date('h:i A', strtotime($borrowTime));

        $message = "Hello, ".$user['firstname']." ".$user['lastname'].",<br><br>
        You have borrowed an equipment. Please go to the IT Services Office to confirm and claim your equipment.<br><br>
        <strong>Borrow Status:</strong> ".$status."<br>
        <strong>Requester:</strong> ".$user['firstname']." ".$user['lastname']." (".$user['id_number'].")<br><br>
        <strong>Borrow Details:</strong><br>
        <strong>Room:</strong> ".$roomNumber."<br>
        <strong>Date of Borrow:</strong> ".$formattedDate."<br>
        <strong>Borrow Time:</strong> ".$formattedTime."<br>
        <strong>Borrowed Equipment:</strong> ".$equipmentName."<br><br>
        - From FEU Institute of Technology";

        $this->email->setTo($user['email']);
        $this->email->setSubject('Equipment Borrow Confirmation');
        $this->email->setMessage($message);

        return $this->email->send();
    }

    public function sendReturnConfirmationEmail(array $user, string $equipmentName, string $roomNumber = '', string $borrowDate = '', string $borrowTime = ''): bool
    {
        $message = "Hello, ".$user['firstname']." ".$user['lastname'].",<br><br>
        This is to acknowledge that your borrowed equipment has been returned.<br><br>
        <strong>Borrow Status:</strong> Returned<br>
        <strong>Requester:</strong> ".$user['firstname']." ".$user['lastname']." (".$user['id_number'].")<br><br>
        <strong>Borrow Details:</strong><br>";
        
        if (!empty($roomNumber)) {
            $message .= "<strong>Room:</strong> ".$roomNumber."<br>";
        }
        if (!empty($borrowDate)) {
            $formattedDate = date('M d, Y', strtotime($borrowDate));
            $message .= "<strong>Date of Borrow:</strong> ".$formattedDate."<br>";
        }
        if (!empty($borrowTime)) {
            $formattedTime = date('h:i A', strtotime($borrowTime));
            $message .= "<strong>Borrow Time:</strong> ".$formattedTime."<br>";
        }
        
        $message .= "<strong>Borrowed Equipment:</strong> ".$equipmentName."<br><br>
        - From FEU Institute of Technology";

        $this->email->setTo($user['email']);
        $this->email->setSubject('Equipment Return Confirmation');
        $this->email->setMessage($message);

        return $this->email->send();
    }

    public function sendReserveConfirmationEmail(array $user, string $equipmentName, string $roomNumber, string $reserveDate, string $reserveTime, string $status = 'Pending'): bool
    {
        $formattedDate = date('M d, Y', strtotime($reserveDate));
        $formattedTime = date('h:i A', strtotime($reserveTime));

        $message = "Hello, ".$user['firstname']." ".$user['lastname'].",<br><br>
        You have reserved an equipment. Please go to the IT Services Office to confirm and claim your equipment.<br><br>
        <strong>Reservation Status:</strong> ".$status."<br>
        <strong>Requester:</strong> ".$user['firstname']." ".$user['lastname']." (".$user['id_number'].")<br><br>
        <strong>Reservation Details:</strong><br>
        <strong>Room:</strong> ".$roomNumber."<br>
        <strong>Date of Reservation:</strong> ".$formattedDate."<br>
        <strong>Reserved Time:</strong> ".$formattedTime."<br>
        <strong>Reserved Equipment:</strong> ".$equipmentName."<br><br>
        - From FEU Institute of Technology";

        $this->email->setTo($user['email']);
        $this->email->setSubject('Equipment Reservation Confirmation');
        $this->email->setMessage($message);

        return $this->email->send();
    }

    public function sendReserveReturnConfirmationEmail(array $user, string $equipmentName, string $roomNumber = '', string $reserveDate = '', string $reserveTime = ''): bool
    {
        $message = "Hello, ".$user['firstname']." ".$user['lastname'].",<br><br>
        This is to acknowledge that your reserved equipment has been returned.<br><br>
        <strong>Reservation Status:</strong> Complete<br>
        <strong>Requester:</strong> ".$user['firstname']." ".$user['lastname']." (".$user['id_number'].")<br><br>
        <strong>Reservation Details:</strong><br>";
        
        if (!empty($roomNumber)) {
            $message .= "<strong>Room:</strong> ".$roomNumber."<br>";
        }
        if (!empty($reserveDate)) {
            $formattedDate = date('M d, Y', strtotime($reserveDate));
            $message .= "<strong>Date of Reservation:</strong> ".$formattedDate."<br>";
        }
        if (!empty($reserveTime)) {
            $formattedTime = date('h:i A', strtotime($reserveTime));
            $message .= "<strong>Reserved Time:</strong> ".$formattedTime."<br>";
        }
        
        $message .= "<strong>Reserved Equipment:</strong> ".$equipmentName."<br><br>
        - From FEU Institute of Technology";

        $this->email->setTo($user['email']);
        $this->email->setSubject('Equipment Reservation Return Confirmation');
        $this->email->setMessage($message);

        return $this->email->send();
    }

    public function sendReserveCancellationEmail(array $user, string $equipmentName, string $reserveDate, string $reserveTime): bool
    {
        $formattedDate = date('M d, Y', strtotime($reserveDate));
        $formattedTime = date('h:i A', strtotime($reserveTime));

        $message = "Hello, ".$user['firstname']." ".$user['lastname'].",<br><br>
        We regret to inform you that your equipment reservation has been cancelled.<br><br>
        <strong>Reservation Details:</strong><br>
        Equipment: ".$equipmentName."<br>
        Date: ".$formattedDate."<br>
        Time: ".$formattedTime."<br><br>
        If you have any questions or concerns, please contact the IT Services Office.<br><br>
        - From FEU Institute of Technology";

        $this->email->setTo($user['email']);
        $this->email->setSubject('Equipment Reservation Cancellation');
        $this->email->setMessage($message);

        return $this->email->send();
    }

    public function sendReserveRescheduleEmail(array $user, string $equipmentName, string $oldDate, string $oldTime, string $oldRoom, string $newDate, string $newTime, string $newRoom): bool
    {
        $oldFormattedDate = date('M d, Y', strtotime($oldDate));
        $oldFormattedTime = date('h:i A', strtotime($oldTime));
        $newFormattedDate = date('M d, Y', strtotime($newDate));
        $newFormattedTime = date('h:i A', strtotime($newTime));

        $message = "Hello, ".$user['firstname']." ".$user['lastname'].",<br><br>
        Your equipment reservation has been rescheduled by the IT Services Office.<br><br>
        <strong>Equipment:</strong> ".$equipmentName."<br><br>
        <strong>Previous Reservation:</strong><br>
        Date: ".$oldFormattedDate."<br>
        Time: ".$oldFormattedTime."<br>
        Room: ".$oldRoom."<br><br>
        <strong>New Reservation:</strong><br>
        Date: ".$newFormattedDate."<br>
        Time: ".$newFormattedTime."<br>
        Room: ".$newRoom."<br><br>
        Please note the updated date, time, and room number for your reservation.<br><br>
        - From FEU Institute of Technology";

        $this->email->setTo($user['email']);
        $this->email->setSubject('Equipment Reservation Rescheduled');
        $this->email->setMessage($message);

        return $this->email->send();
    }
    
}