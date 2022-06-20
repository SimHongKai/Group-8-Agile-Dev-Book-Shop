<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;  
use PHPMailer\PHPMailer\Exception;

class EmailController extends Controller
{

    // ========== [ Compose Email ] ================
    public function sendEmail(Request $request) {
        //require base_path("vendor/autoload.php");
        $mail = new PHPMailer();     // Passing `true` enables exceptions
 
        // Email server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.mailgun.org';             //  smtp host 
        $mail->SMTPAuth = true;
        $mail->Username = 'postmaster@sandboxdaf05829fd4445dd9f83a7264a1511d9.mailgun.org';   //  sender username
        $mail->Password = '59a0ff77b8300b507dc661aacda8f580-50f43e91-38c5d5e0';       // sender password
        $mail->SMTPSecure = 'tls';                  // encryption - ssl/tls
        $mail->Port = 587;                         // port - 587/465

        $mail->setFrom('postmaster@sandboxdaf05829fd4445dd9f83a7264a1511d9.mailgun.org', 'SenderName');
        $mail->addAddress('simhk625@gmail.com');

        $mail->addReplyTo('simhk625@gmail.com', 'sim');

        $mail->isHTML(true);                // Set email content format to HTML

        $mail->Subject = "Order";
        $mail->Body    = '<div class="container" style="padding: 1rem; background: #f5f5f5;">
                            <p>Good Morning XYZ!</p>
                            <p>
                                Welcome to Laravel. This is a demo of sending emails through
                                the Mailgun email service.
                            </p>
                        </div>';

        if( !$mail->send() ) {
            return view('auth.login')->with("fail", "Email not sent.")->withErrors($mail->ErrorInfo);
        }
        
        else {
            return view('auth.registration')->with("success", "Email has been sent.");
        }
    }
}
