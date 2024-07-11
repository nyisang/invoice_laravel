<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\TBcreateusersregistration;
use App\Models\TBMpesaTransaction;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;



use Carbon\Carbon;

class HomeController extends Controller
{

    public function welcome()
    { 
      
return view('/');        
    }

    public function signuppage()
    {

        return view('signuppage');
       
    }
    
    public function dashboard()
    {  $usersid = @Session::get('id')?:null;
        $invoiceusers = @TBcreateusersregistration::getWhere(["id" => $usersid],true); 
        $alltransactions = @TBMpesaTransaction::all();  
        return view('dashboard',compact("invoiceusers","alltransactions"));
        
       
    }

    public function logininvoice(Request $request)
    {
        try{
    
            $username = $request->input('phonenumber');
            $password = $request->input('password');
            if ( isset($username) && isset($password)){
                $records = TBcreateusersregistration::getWhere(["phonenumber" => $username],true);
                Log::info("recorded all: ".json_encode($records));
    
                if (isset($records->{'password'})){
                    if ($records->{'password'} == $password) {
                        $id = $records->{"id"};
                        $phonenumber = $records->{"phonenumber"};

                        Session::put("id",$id);
                        Session::put("phonenumber",$phonenumber);
                        return redirect()->intended('dashboard');
    
                    }
                    return response([
                        "error" => true,
                        "message" => "Invalid credentials try again!"
                    ]);
                }
                return response([
                    "error" => true,
                    "message" => "User not found in our systems!"
                ]);
            }
            return response([
                "error" => true,
                "message" => "Enter required details!"
            ]);
        }catch (Exception $e){
            return response([
                "error" => true,
                "message" => "Error! ".$e->getMessage(),"Line".$e->getLine()
            ]);
        }
    }
    

    public function store_users(Request $request)
    {

     
        try {

            $lastRec = @TBcreateusersregistration::orderBy('id', "desc")->first();
            $dateTime = Carbon::now();
              $userid = (int)$lastRec->{'id'} + 1;
            $fname = $request->input('firstname');
            $lname = $request->input('lastname');
            $pnumber = $request->input('phonenumber');
            $password =  $request->password;
     
            $data = [
                 "id" => $userid,
                "date" => $dateTime,
                'first_name' => $fname,
                'last_name' => $lname,
                'phonenumber' => $pnumber,
                'password' => $password,
      

            ];
              TBcreateusersregistration::create($data);

            return redirect(url('/'))->with('message', 'user  created successfully');
        } catch (Exception $e){
            return $e->getMessage();
        }
    }
    

    public function lipaNaMpesaPassword()
    {
        try {
            // Timestamp
            $timestamp = Carbon::now()->format('YmdHms');
            // Passkey
            $passKey = "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";
            $businessShortCode = 174379;
            // Generate password
            $mpesaPassword = base64_encode($businessShortCode . $passKey . $timestamp);

            return $mpesaPassword;
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function newAccessToken()
    {
        $consumerKey = "2sh2YA1fTzQwrZJthIrwLMoiOi3nhhal";
        $consumerSecret = "CKaCnw224K4Lc56w";
        $credentials = base64_encode($consumerKey . ":" . $consumerSecret);
        $url = "https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, ["Authorization: Basic " . $credentials, "Content-Type:application/json"]);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $curlResponse = curl_exec($curl);
        $accessToken = json_decode($curlResponse);
        curl_close($curl);

        return $accessToken->access_token;
    }

    public function stkPush(Request $request)
    {
        try {
            $lastRec = TBMpesaTransaction::orderBy('id', "desc")->first();
            $transid =1;// (int) $lastRec->id + 1;
            $usersid = @Session::get('id')?:null;
            $usersphone = @Session::get('phonenumber')?:null;

            $amount = $request->input('amount');
            $phoneNumber = $request->input('phonenumber');
            if ($phoneNumber == null){
                return $usersphone;
            } 

        
            $formattedNumber = $this->formatKenyanPhoneNumber($phoneNumber);
            Log::info("Phone number formatted: " . json_encode($formattedNumber));

            $dateTime = Carbon::now();
            Log::info('Request MPESA Payload: ' . json_encode($request->all()));

            $url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
            $curlPostData = [
                'date' => $dateTime,
                'userid' => $usersid,
                'TransAmount' => $amount,
                'InvoiceID' => $transid,
                'BusinessShortCode' => 174379,
                'Password' => $this->lipaNaMpesaPassword(),
                'TransactionType' => 'CustomerPayBillOnline',
                'PartyA' => $formattedNumber,
                'PartyB' => 174379,
                'MSISDN' => $formattedNumber,
                'response' => 'https://kaziyangu.nyisoftech.co.ke/api/mpesa_callback_url',
                'BillRefNumber' =>$formattedNumber,
                'TransactionDesc' => "lipa Na M-PESA",
            ];

            $dataString = json_encode($curlPostData);

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_HTTPHEADER, ['Content-Type:application/json', 'Authorization:Bearer ' . $this->newAccessToken()]);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $dataString);
            $curlResponse = curl_exec($curl);

            return response(['error' => true, 'message' => 'Your request is being processed']);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function MpesaRes(Request $request)
    {
        $response = json_decode($request->getContent());

        $trn = new TBMpesaTransaction;
        $trn->response = json_encode($response);
        $trn->save();
    }

    private function formatKenyanPhoneNumber($phoneNumber)
    {
        $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);

        if (substr($phoneNumber, 0, 1) === '0') {
            $phoneNumber = substr($phoneNumber, 1);
        }

        if (substr($phoneNumber, 0, 1) !== '+') {
            $phoneNumber = '+254' . $phoneNumber;
        }

        return $phoneNumber;
    }

}