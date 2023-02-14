<?php namespace App\Controllers;
   
use App\Models\UsersModel;
use App\Models\UserSubscriptionsModel;
use App\Models\LogsModel;

class StripeController extends AuthBaseController 
{
    
    /**
     * Get All Data from this method.
     *
     * @return Response
    */
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger) {
		parent::initController($request, $response, $logger);
        \Stripe\Stripe::setApiKey(getenv('sk_key'));
        $this->api_error = '';
    }

    /**
     * Payment page
     */
    public function index() {
        if (!$this->session->get('login')) {
            redirect()->to(base_url().'/auth/login')->send(); 
            exit();
		} else if ($this->session->get('login')['active'] == 0) {
            redirect()->to(base_url().'/auth/login')->send(); 
            exit();
        }
        
        $usersModel = new UsersModel();
        $user = $usersModel->find($this->session->get('login')['id']);
        if ($this->session->get('expire_time') != $user['expire_date']) {
            $this->session->set('expire_time', $user['expire_date']);
        }
        $userSubscriptionModel = new UserSubscriptionsModel();
        $usersubscription = $userSubscriptionModel->where("user_id", $user['id'])->first();
        $data_subscription = [];
        if ($usersubscription) {
            $data_subscription = [
                'subscription_plan'=> $usersubscription['plan'],
                'stripe_subscription_id'=> $usersubscription['stripe_subscription_id'],
                'stripe_customer_id'=> $usersubscription['stripe_customer_id'],
                'stripe_plan_id'=> $usersubscription['stripe_plan_id'],
                'plan_amount'=> $usersubscription['plan_amount'],
                'plan_amount_currency'=> $usersubscription['plan_amount_currency'],
                'plan_interval'=> $usersubscription['plan_interval'],
                'plan_interval_count'=> $usersubscription['plan_interval_count'],
                'plan_period_start'=> $usersubscription['plan_period_start'],
                'plan_period_end'=> $usersubscription['plan_period_end'],
                'payer_email'=> $usersubscription['payer_email'],
                'status'=> $usersubscription['status'],
                'updated_at'=> $usersubscription['updated_at'],
            ];
        }

        return $this->view('payment/pricingtable', $data_subscription);
    }

    public function stripePay()
    {
        $this->beforeApi();

        try {

            \Stripe\Stripe::setApiKey(getenv('sk_key'));
            // retrieve JSON from POST body
            $days = $this->request->getPost('plan');
            
            $price = 0;
            switch ($days) {
                case 30:
                    $price = 1500;
                    break;
                case 90:
                    $price = 4000;
                    break;
                case 180:
                    $price = 7000;
                    break;
                default:
                    $price = 9999999;
            }

            $receipt_email = $this->session->get('login')['email'];

            $paymentIntent = \Stripe\PaymentIntent::create([
                'amount' => $price,
                'currency' => 'jpy',
                'receipt_email' => $receipt_email,
            ]);
            
            $output = [
              'clientSecret' => $paymentIntent->client_secret,
            ];
          
            return json_encode([
                "code"=> "200",
                "result"=> $output,
            ]);
        } catch(\Stripe\Exception\CardException $e) {
            // echo 'Status is:' . $e->getHttpStatus() . '\n';
            return json_encode([
                'code'=> 501,
                'error' => $e->getError()
            ]);
        } catch (\Stripe\Exception\RateLimitException $e) {
            // Too many requests made to the API too quickly
            return json_encode([
                'code'=> 502,
                'error' => $e->getError()
            ]);
        } catch (\Stripe\Exception\InvalidRequestException $e) {
            // Invalid parameters were supplied to Stripe's API
            return json_encode([
                'code'=> 503,
                'error' => $e->getError()
            ]);
        } catch (\Stripe\Exception\AuthenticationException $e) {
            // Authentication with Stripe's API failed
            // (maybe you changed API keys recently)
            return json_encode([
                'code'=> 401,
                'error' => $e->getError()
            ]);
        } catch (\Stripe\Exception\ApiConnectionException $e) {
            // Network communication with Stripe failed
            return json_encode([
                'code'=> 402,
                'error' => $e->getError()
            ]);
        } catch (\Stripe\Exception\ApiErrorException $e) {
            // Display a very generic error to the user, and maybe send
            // yourself an email
            return json_encode([
                'code'=> 403,
                'error' => $e->getError(),
            ]);
        } catch (Exception $e) {
            // Something else happened, completely unrelated to Stripe
            // http_response_code(500);
            return json_encode([
                'code'=> 300,
                'error' => $e->getMessage()
            ]);
        }
    }

    public function stripeSuccess()
    {
        $this->beforeApi();

        $intent = $this->request->getPost("intent");

        $amount = $intent["amount"];
        $client_secret = $intent["client_secret"];
        $created = $intent["created"];
        $currency = $intent["currency"];
        $id = $intent["id"];
        $livemode = $intent["livemode"];
        $object = $intent["object"];
        $payment_method = $intent["payment_method"];
        $payment_method_types = $intent["payment_method_types"];
        $status = $intent["status"];
        $receipt_email = $intent["receipt_email"];

        if ($status == "succeeded") {
            $period = 0;
            switch($amount) {
                case 1500:
                    $period = 30;
                    break;
                case 4000:
                    $period = 90;
                    break;
                case 7000:
                    $period = 180;
                    break;
            }

            // Update period to use
            $usersModel = new UsersModel();
            $user = $usersModel->where("email", $receipt_email)->first();

            if ($user) {
                $expire_date_old = $user["expire_date"];

                $date1 = new \DateTime($expire_date_old);
                $date2 = new \DateTime();
                
                if ($date1->getTimestamp() < $date2->getTimestamp()) {
                    $expire_date_old = date("Y-m-d H:i:s");
                }
                $expire_date = date(
                    'Y-m-d H:i:s', 
                    strtotime('+'.$period.' days', strtotime($expire_date_old))
                );
                
                $data = [
                    'plan' => $period,
                    'expire_date'    => $expire_date,
                ];
    
                $updated = $usersModel->update($user['id'], $data);
                $user = $usersModel->find($user["id"]);
    
                $this->session->set('login', $user);
                $this->session->set('expire_time', $user['expire_date']);
                $this->session->set('config', json_decode($user['config'], true) ?: []);
    
                if ($updated) {
                    $data = [
                        "to"=> $receipt_email,
                        "subject"=> "ご利用いただきありがとうございます",
                        "content"=> "\
                            ".$amount."円の料金がnene-maru.comに送信されました。\
        
                            あなたは".$period."日間の利用期間を許可しました。\
                            
                            あなたの利用期間は".""."までです。\
                            
                            nene-maru.comに積極的な支援いただきありがとうございます。\
                            
                            あなたの声にいつが耳を傾けています。\
                        "
                    ];
                    //$this->sendMail($data);
                    return json_encode([
                        "code"=> "200",
                        "result"=> "success",
                        "msg"=> $intent,
                    ]); 
                } else {
                    return json_encode([
                        "code"=> "501",
                        "result"=> "fail",
                        "msg"=> "database error. please contact developer",
                    ]); 
                }
            } else {
                return json_encode([
                    "code"=> "401",
                    "result"=> "success",
                    "msg"=> $receipt_email."is not registered",
                ]);
            }
        } else {
            return json_encode([
                "code"=> "304",
                "result"=> "success",
                "msg"=> $intent,
            ]); 
        }
    }

    public function stripeSaveInfo()
    {
        $this->beforeApi();
        
        try {
            // Card infomation
            $customerId = $this->request->getPost('customerId');
            $paymentId = $this->request->getPost('paymentId');

        } catch (Exception $e) {
            // Something else happened, completely unrelated to Stripe
            // http_response_code(500);
            return json_encode([
                'code'=> 300,
                'error' => $e->getMessage()
            ]);
        }
    }

    public function stripeSetupIntent()
    {
        $this->beforeApi();
        
        try {
            \Stripe\Stripe::setApiKey(getenv('sk_key'));
            $customer = \Stripe\Customer::create();
            $setipIntent = \Stripe\SetupIntent::create([
                'customer' => $customer->id
            ]);

            return json_encode([
                "code"=> "200",
                "result"=> $setipIntent,
            ]);
        } catch (Exception $e) {
            // Something else happened, completely unrelated to Stripe
            // http_response_code(500);
            return json_encode([
                'code'=> 300,
                'error' => $e->getMessage()
            ]);
        }
    }

    private function addCustomer($name, $email, $token)
    {
        try { 
            // Add customer to stripe 
            $customer = \Stripe\Customer::create(array( 
                'name' => $name, 
                'email' => $email, 
                'source'  => $token 
            )); 
            return $customer; 
        }catch(Exception $e) { 
            $this->api_error = $e->getMessage(); 
            return false; 
        } 
    }

    private function createPlan($planName, $planPrice, $planInterval, $planIntervalCount)
    {
        // Convert price to cents 
        // $priceCents = ($planPrice*100); 
        $currency = 'jpy'; 
         
        try { 
            // Create a plan 
            $plan = \Stripe\Plan::create(array( 
                "product" => [ 
                    "name" => $planName 
                ], 
                "amount" => $planPrice, 
                "currency" => $currency, 
                "interval" => $planInterval, 
                "interval_count" => $planIntervalCount,
            )); 
            return $plan; 
        }catch(Exception $e) { 
            $this->api_error = $e->getMessage(); 
            return false; 
        } 
    }

    private function createSubscription($customerID, $plan)
    {
        try { 
            // Creates a new subscription 
            $subscription = \Stripe\Subscription::create(array( 
                "customer" => $customerID, 
                "items" => array( 
                    array( 
                        "plan" => $plan
                    ), 
                ), 
                // "billing_cycle_anchor" => strtotime('+1 years'),
            )); 
             
            // Retrieve charge details 
            $subsData = $subscription->jsonSerialize(); 
            return $subsData; 
        }catch(Exception $e) { 
            $this->api_error = $e->getMessage(); 
            return false; 
        } 
    }

    private function subscriptionSchedule($subscription_id)
    {
        try {
            $scheduled = \Stripe\SubscriptionSchedule::create([
                'from_subscription' => $subscription_id,
            ]);
            $scheduled = $scheduled->jsonSerialize();
            return $scheduled;
        }catch(Exception $e) { 
            $this->api_error = $e->getMessage(); 
            return false; 
        } 
    }

    public function stripeSubscription()
    {
        $token  = $this->request->getPost('stripeToken'); 
        $name = $this->request->getPost('name'); 
        $email = $this->request->getPost('email'); 
        $planName = $this->request->getPost('plan'); 
        // Plan info 
        $planName = $this->request->getPost('plan'). "MODE"; 
        $planPrice = 0; 
        $planInterval = "month"; 
        $planIntervalCount = "1";
        switch ($planName) {
            case 30:
                $planPrice = 1500;
                $planIntervalCount = "1";
                break;
            case 90:
                $planPrice = 4000;
                $planIntervalCount = "3";
                break;
            case 180:
                $planPrice = 7000;
                $planIntervalCount = "6";
                break;
        }

        $customer = $this->addCustomer($name, $email, $token);

        if ($customer) {
            $plan = $this->createPlan($planName, $planPrice, $planInterval, $planIntervalCount);
            if ($plan) {
                $subscription = $this->createSubscription($customer->id, $plan->id);

                if ($subscription) {
                    if ($subscription['status'] == 'active') {

                        $subscrId = $subscription['id'];
                        $custId = $subscription['customer'];
                        $planID = $subscription['plan']['id']; 
                        $planAmount = $subscription['plan']['amount'];
                        $planCurrency = $subscription['plan']['currency'];
                        $planInterval = $subscription['plan']['interval'];
                        $planIntervalCount = $subscription['plan']['interval_count']; 
                        $created = date('Y-m-d H:i:s', $subscription['created']);
                        $current_period_start = date('Y-m-d H:i:s', $subscription['current_period_start']);
                        $current_period_end = date('Y-m-d H:i:s', $subscription['current_period_end']);
                        $status = $subscription['status'];

                        $subscripData = array( 
                            'user_id' => $this->session->get('login')['id'], 
                            'plan' => $planName, 
                            'stripe_subscription_id' => $subscrId, 
                            'stripe_customer_id' => $custId, 
                            'stripe_plan_id' => $planID, 
                            'plan_amount' => $planAmount, 
                            'plan_amount_currency' => $planCurrency, 
                            'plan_interval' => $planInterval, 
                            'plan_interval_count' => $planIntervalCount, 
                            'plan_period_start' => $current_period_start, 
                            'plan_period_end' => $current_period_end, 
                            'payer_email' => $email, 
                            'created_at' => $created, 
                            'status' => $status 
                        ); 

                        $userSubscriptionModel = new UserSubscriptionsModel();
                        // save to database and update user's status
                        $exisingSubscription = $userSubscriptionModel->where('user_id', $this->session->get('login')['id'])->first();

                        $updated = false;
                        if ($exisingSubscription) {
                            $result = $this->cancelSubscription($exisingSubscription['stripe_subscription_id']);
                            if ($result['code'] == '200') {
                                $updated = true;
                            }
                        }
                        $subscription_local = $userSubscriptionModel->insert($subscripData);

                        $scheduled = $this->subscriptionSchedule($subscription['id']);
                        
                        return json_encode([
                            'code'=> "200",
                            'result'=> $subscription_local,
                            'updated'=> $updated,
                            'scheduled'=> $scheduled,
                        ]);
                    }
                }
            }
        }
        return json_encode([
            'code'=> "403",
        ]);
    }

    private function cancelSubscription($subscription_id) 
    {
        $stripe = new \Stripe\StripeClient(getenv('sk_key'));
        $stripe_obj = $stripe->subscriptions->cancel(
            $subscription_id,
            [],
        );
        if ($stripe_obj['status'] == "canceled") {
            $userSubscriptionModel = new UserSubscriptionsModel();
            $userSubscriptionModel->where('stripe_subscription_id', $subscription_id)->delete();
            return [
                'code'=> "200",
                'result'=> $stripe_obj,
            ];
        } else {
            return [
                'code'=> "300",
                'result'=> $stripe_obj,
            ];
        }
    }

    public function stripeSubscriptionCancel()
    {
        $subscription_id = $this->request->getPost('subscription_id');
        
        return json_encode($this->cancelSubscription($subscription_id)); 
    }

    public function stripeWebhook() 
    {
        \Stripe\Stripe::setApiKey(getenv('sk_key'));

        $payload = @file_get_contents('php://input');
        $event = null;
        try {
            $event = \Stripe\Event::constructFrom(
                json_decode($payload, true)
            );
        } catch(\UnexpectedValueException $e) {
        // Invalid payload
            echo '⚠️  Webhook error while parsing basic request.';
            http_response_code(400);
            exit();
        }
        // Handle the event
        switch ($event->type) {
        // case 'payment_intent.succeeded':
        //     $this->addlog('stripe', $event->type, 'SDF');
        //     $paymentIntent = $event->data->object; // contains a \Stripe\PaymentIntent
        //     // Then define and call a method to handle the successful payment intent.
        //     // handlePaymentIntentSucceeded($paymentIntent);
        //     break;
        // case 'payment_method.attached':
        //     $this->addlog('stripe', $event->type, 'SDF');
        //     $paymentMethod = $event->data->object; // contains a \Stripe\PaymentMethod
        //     // Then define and call a method to handle the successful attachment of a PaymentMethod.
        //     // handlePaymentMethodAttached($paymentMethod);
        //     break;
        // case 'customer.source.created':
        //     break;
        // case 'customer.created':
        //     break;
        // case 'price.created':
        //     break;
        // case 'plan.created':
        //     break;
        // case 'charge.succeeded':
        //     break;
            
        // case 'customer.updated':
        //     break;
            
        // case 'invoice.created':
        //     break;
            
        // case 'invoice.payment_succeeded':
        //     break;
            
        // case 'invoice.paid':
        //     break;
            
        // case 'payment_intent.succeeded':
        //     break;
            
        // case 'payment_intent.created':
        //     break;

        // case 'customer.subscription.created':
        //     break;
                
        // case 'invoice.finalized':
        //     break;

        // case 'customer.subscription.created':
        //     $this->addlog('stripe', $event->type, json_encode($event->data->object));
        //     break;
        case 'customer.subscription.deleted':
            $subscription_obj = $event->data->object;

            $this->addlog('stripe', $event->type, json_encode($subscription_obj));

            $userSubscriptionModel = new UserSubscriptionsModel();
            $userSubscriptionModel->where('stripe_subscription_id', $subscription_obj->id)->delete();
            break;

        case 'payment_intent.succeeded':
            $this->addlog('stripe', $event->type, json_encode($subscription_obj));
            $customerId = $event->data->object->customer;
            
            $userSubscriptionModel = new UserSubscriptionsModel();
            $userSubscript = $userSubscriptionModel->where("stripe_customer_id", $customerId)->first();

            if ($userSubscript) {
                // Update period to use
                $usersModel = new UsersModel();
                $user = $usersModel->find($userSubscript->id);

                if ($user) {
                    $expire_date_old = $user["expire_date"];

                    $date1 = new \DateTime($expire_date_old);
                    $date2 = new \DateTime();
                    
                    if ($date1->getTimestamp() < $date2->getTimestamp()) {
                        $expire_date_old = date("Y-m-d H:i:s");
                    }
                    $expire_date = date(
                        'Y-m-d H:i:s', 
                        strtotime('+30 days', strtotime($expire_date_old))
                    );
                    
                    $data = [
                        'plan' => $period,
                        'expire_date'    => $expire_date,
                    ];
        
                    $updated = $usersModel->update($user['id'], $data);
                }
            }
            break;

        default:
            $this->addlog('stripe', $event->type, json_encode($event->data->object));
            // Unexpected event type
            echo 'Received unknown event type';
        }
        http_response_code(200);

    }
}