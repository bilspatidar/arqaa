<?php
   require APPPATH . '/libraries/REST_Controller.php';
   use Restserver\Libraries\REST_Controller;

class Stripecontroller extends REST_Controller {
    
    /**
     * CONSTRUCTOR | LOAD MODEL
     *
     * @return Response. stripe-php-master
    */
    public function __construct() {
        $this->cors_header();
        parent::__construct();
        $this->load->helper('security');
          require_once(APPPATH . 'libraries/stripe-php-master/init.php');

        // Set your Stripe API keys (you should store these securely, e.g. in environment variables)
         \Stripe\Stripe::setApiKey('sk_test_51QNXYmG3HDKGDuThH5Gwxj6OTJW34aWPGsyOC7xuZngvBHwEsma5VVDY0KhUh3ssWaPeGy2bliTrgQVG8gV408tM00HPhscV1e'); // Replace with your secret key

    }
    
    public function create_payment_intent_post() {
        // Get the amount and currency from the request
         $input_data = file_get_contents('php://input');
        $request_data = json_decode($input_data, true);
        $amount = $request_data['amount']; // amount in cents
        $currency = $request_data['currency'];

        try {
            // Create a PaymentIntent with the amount and currency
            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => $amount,
                'currency' => $currency,
            ]);

            // Send the client_secret to the frontend
            echo json_encode([
                'clientSecret' => $paymentIntent->client_secret,
            ]);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            // Handle error and return it as a JSON response
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
    
 
}
