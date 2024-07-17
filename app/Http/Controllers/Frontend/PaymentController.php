<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\OrderService;
use GuzzleHttp\Client;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaymentController extends Controller
{

    public function index(): View
    {


        if (!session()->has('delivery_fee') || !session()->has('address')) {
            throw ValidationException::withMessages(['Something went wrong']);
        }

        $subtotal = cartTotal();
        $delivery = session()->get('delivery_fee') ?? 0;
        $discount = session()->get('coupon')['discount'] ?? 0;
        $grandTotal = grandCartTotal($delivery);

        return view('frontend.pages.payment-view', [
            'subtotal' => $subtotal,
            'delivery' => $delivery,
            'discount' => $discount,
            'grandTotal' => $grandTotal
        ]);
    }

    public function makePayment(Request $request, OrderService $orderService)
    {
        $request->validate([
            'payment_gateway' => ['required', 'string', 'in:paypal']
        ]);


        /** Create Order */

        if ($orderService->createOrder()) {

            // redirect user to the payment host
            switch ($request->payment_gateway) {
                case 'paypal':
                   return response(['redirect_url'=>route('paypal.payment')]);
                    break;

                default:
                    #code
                    break;
            }
        }

        return false;
    }


    public function setPaypalConfig()
    {
      $config = [
          'mode'    => config('gatewaySettings.paypal_account_mode'), // Can only be 'sandbox' Or 'live'. If empty or invalid, 'live' will be used.
          'sandbox' => [
              'client_id'         => config('gatewaySettings.paypal_api_key'),
              'client_secret'     => config('gatewaySettings.paypal_secret_key'),
              'app_id'            => 'APP-80W284485P519543T',
          ],
          'live' => [
              'client_id'         => config('gatewaySettings.paypal_api_key'),
              'client_secret'     => config('gatewaySettings.paypal_secret_key'),
              'app_id'            => env('PAYPAL_LIVE_APP_ID', ''),
          ],

          'payment_action' => 'Sale', // Can only be 'Sale', 'Authorization' or 'Order'
          'currency'       => config('gatewaySettings.paypal_currency'),
          'notify_url'     => env('PAYPAL_NOTIFY_URL', ''), // Change this accordingly for your application.
          'locale'         => 'en_US', // force gateway language  i.e. it_IT, es_ES, en_US ... (for express checkout only)
          'validate_ssl'   => true, // Validate SSL when creating api client.
      ];
      return $config;
    }

    //PayPal Payment
    public function payWithPaypal()
    {

        $config = $this->setPaypalConfig();
        $provider = new PayPalClient($config);

        $provider->getAccessToken();
        /** calculate payable amount */

        $grandTotal = session()->get('grand_total');
        $payableAmount = round($grandTotal * config('gatewaySettings.paypal_rate'));

        $response = $provider->createOrder([
            'intent' => "CAPTURE",
            'application_context' => [
                'return_url' => route('paypal.success'),
                'cancel_url' => route('paypal.cancel')
            ],
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => config('gatewaySettings.paypal_currency'),
                        'value' => $payableAmount
                    ]
                ]
            ]
        ]);

        if($response && $response !== null){
            foreach($response['links'] as $link){
                if($link['rel']==='approve'){
                    return redirect()->away($link['href']);
                }
            }
        }
       // dd($response);
    }


    public function paypalSuccess(Request $request)
    {
        $config = $this->setPaypalConfig();
        $provider = new PayPalClient($config);
        $provider->getAccessToken();

        $response = $provider->capturePaymentOrder($request->token);

        if(isset($response['status']) && $response['status'] === 'COMPLETED'){
            dd('Payment Competed');
        }
    }


    public function paypalCancel()
    {

    }



}

