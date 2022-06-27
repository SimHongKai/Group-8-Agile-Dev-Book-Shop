<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;  
use PHPMailer\PHPMailer\Exception;
use DB;
use App\Models\Postage;

class EmailController extends Controller
{

    public function sendOrderEmail(){
        $this->sendEmail(2);
    }

    // ========== [ Compose Email ] ================
    public function sendEmail($orderID) {
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

        $mail->setFrom('postmaster@sandboxdaf05829fd4445dd9f83a7264a1511d9.mailgun.org', 'Book Shop Group 8');
        $mail->addAddress('simhk625@gmail.com');

        $mail->addReplyTo('simhk625@gmail.com', 'sim');

        $mail->isHTML(true);                // Set email content format to HTML

        $mail->Subject = "Order Receipt";
        $mail->Body = $this->composeEmailBody($orderID);
                                

        if( !$mail->send() ) {
            return view('auth.login')->with("fail", "Email not sent.")->withErrors($mail->ErrorInfo);
        }
        
        else {
            return view('auth.registration')->with("success", "Email has been sent.");
        }
    }

    public function composeEmailBody($orderID){
        $orderItemData = $this->getOrderItems($orderID);
        $subTotal = 0;
        $postage = 0;
        $emailBody  = '<div class="container" style="padding: 1rem; background: #f5f5f5;">
                        <p>Thank You for making an order at our online book shop!</p>
                        <p>You have purchased the following items</p>
                        <table style="border:1px solid;width:600px;text-align:left">
                            <tbody>
                                <tr>
                                    <th>Book</th>
                                    <th>Quantity</th>
                                    <th>Unit Price (RM)</th>
                                    <th>Total Amount (RM)</th>
                                </tr>';
        // loop order Items
        foreach($orderItemData as $row){
            // change Subtotal and Postage to be obtained from Order table
            $Amount = $row->qty * $row->retailPrice;
            $subTotal += $Amount;
            $emailBody .=  '<tr>
                                <td>' . $row->bookName . '</td>
                                <td>' . $row->qty . '</td>
                                <td>' . $row->retailPrice . '</td>
                                <td>' . number_format($Amount, 2) . '</td>
                            </tr>';
        }

        $emailBody .= '</tbody>
                        </table>
                        </div>
                        </br></br>
                        <p>Sub Total (RM): ' . number_format($subTotal, 2) . '</p>
                        <p>Postage Fees (RM): ' . number_format($postage, 2) . '</p>
                        <p>Total (RM): ' . number_format(($subTotal + $postage), 2) . '</p>';

        return $emailBody;
    }


    //should change the shopping cart to order item, $userID to orderID

    public function getOrderItems($userID){
        if($userID){
            $shoppingCart = DB::table('shopping_cart')
            ->select('shopping_cart.qty', 'shopping_cart.ISBN13', 'shopping_cart.userID', 'stock.retailPrice', 'stock.bookName')
            ->join('stock', 'shopping_cart.ISBN13', '=', 'stock.ISBN13')
            ->where('shopping_cart.userID', '=', $userID)
            ->get();
            $postage = Postage::get();
            return $shoppingCart;
        }

        // if ($orderID){
        //     $orderItem = DB::table('orderitem')
        //     ->select('orderitem.qty', 'orderitem.ISBN13', 'stock.retailPrice', 'stock.bookName')
        //     ->join('stock', 'orderitem.ISBN13', '=', 'stock.ISBN13')
        //     ->where('orderitem.orderID', '=', $orderID)
        //     ->get();
        //     return $orderItem;
        // }
    }

    // public function getOrder($orderID){
    //     $order = Order::find($orderID);
    //     return $order;
    // }
}
