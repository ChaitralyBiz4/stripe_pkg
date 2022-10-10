<?php 
namespace Chaitralybiz4\StripePkg;
use Stripe;
require_once('vendor/autoload.php');
//global $stripe;
class stripeAccountClass {
    //this is stripe class

    static $stripe_api_key;

    public function __construct($stripe_api_key){
        if($stripe_api_key == '')
        {
            return false;
        }
        $this -> stripe_api_key = $stripe_api_key;
    }
    
    function initializeStripeClient(){
        $stripe = new \Stripe\StripeClient(["api_key" => $this->stripe_api_key]);
       return $stripe;
    }

    function setStripeApiKey(){
        \Stripe\Stripe::setApiKey($this->stripe_api_key);

    }

    function createStripeConnectAccount($account_type){
        if($account_type == '')
        {
            return false;
        }
        //$stripe = new \Stripe\StripeClient(["api_key" => $stripe_api_key]);
        if($account_type != 'standard'){
            $error_message = "Use 'standard' as account type";
            return $error_message;
        }
        $stripe = self::initializeStripeClient($this->stripe_api_key);
        $stripe_account = $stripe->accounts->create([
                 'type' => $account_type,
         ]);
         return $stripe_account;
    }

    function createStripeConnectAccountLink($account_id){
        if($account_id == '')
        {
            return false;
        }
        $stripe = self::initializeStripeClient($this->stripe_api_key);
        $account_link = \Stripe\AccountLink::create([
            'account' => $account_id,
            'refresh_url' => "", 
            'return_url' => "",
            'type' => 'account_onboarding',
        ]);
        return $account_link;
    }

    function retrieveStripeAccount($account_id){
        if($account_id == '')
        {
            return false;
        }
        $stripe = self::initializeStripeClient($this->stripe_api_key);
        $stripe_account_data = $stripe->accounts->retrieve($account_id);
        return $stripe_account_data;
    }
   

}

?>