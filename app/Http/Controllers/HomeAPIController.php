<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TBcreateusersregistration;
use App\Models\TBInvoice_SalesTotal;
use App\Models\TBMpesaTransaction;
use App\Models\TBInvoice_Sales;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\DB;


use Carbon\Carbon;

class HomeAPIController
{

  
public function loginApi(Request $request)
{     Log::info("Request data: ".json_encode($request->all()));
    try{

        $username = $request->input('Username');
        $password = $request->input('Password');
        
          if ($username == null){
                return response(['error'=>true,'message'=>'Phone number missing']);
            } 
            
              if ($password == null){
                return response(['error'=>true,'message'=>'Password missing']);
            } 
        if ( isset($username) && isset($password)){
            $records = TBcreateusersregistration::getWhere(["phonenumber" => $username],true);
            Log::info("rec: ".json_encode($records));

            if (isset($records->{'password'})){
                if ($records->{'password'} == $password) {
                    $pid = $records->{"id"};
                    $fname = @TBcreateusersregistration::getWhere(['id'=>$pid],true)->{"first_name"}?:"";
                    $lname = @TBcreateusersregistration::getWhere(['id'=>$pid],true)->{"last_name"}?:"";
                    $phone = @TBcreateusersregistration::getWhere(['id'=>$pid],true)->{"phonenumber"}?:"";

                    return response([
                        "error" => false,
                        "message" => "Success!",
                        "pid" => $pid,
                        "fname" => $fname,
                        "lname" => $lname,
                        "phone" => $phone,
                   

                    ],200);
                }
                return response([
                    "error" => true,
                    "message" => "Invalid credentials try again!"
                ],401);
            }
            return response([
                "error" => true,
                "message" => "Credentials not found in our systems!"
            ],404);
        }
        return response([
            "error" => true,
            "message" => "Enter required details!"
        ]);
    }catch (Exception $e){
        return response([
            "error" => true,
            "message" => "Error! ".$e->getMessage(),"Line".$e->getLine()
        ],500);
    }
}

public function store_users_APIs(Request $request)
{

 
    try {

        $lastRec = @TBcreateusersregistration::orderBy('id', "desc")->first();
        $dateTime = Carbon::now();
          $userid = (int)$lastRec->{'id'} + 1;
        $fname = $request->input('firstname');
        $lname = $request->input('lastname');
        $pnumber = $request->input('phonenumber');
        $password = $request->input('Password');
       

        if ($fname == null){
            return response(['error'=>true,'message'=>'Enter First Name']);
        }
        if ($lname == null){
            return response(['error'=>true,'message'=>'Enter Last Name']);
        }

        if ($pnumber == null){
            return response(['error'=>true,'message'=>'Enter Phone Number']);
        }
        if ($password == null){
            return response(['error'=>true,'message'=>'Enter Password']);
        }
        $data = [
             "id" => $userid,
            "date" => $dateTime,
            'first_name' => $fname,
            'last_name' => $lname,
            'phonenumber' => $pnumber,
            'password' => $password,
        ];
          TBcreateusersregistration::create($data);
          return response(['error'=>false,'message'=>'Users Created Successfully.'], 200);

    } catch (Exception $e){
        return $e->getMessage();
    }
}


public function productsoninvoice_sales()
{ try{
  
    $invoiceproducts = @TBInvoice_Sales::getWhere(["status" => 1]);  
     $allmessages = [];
foreach($invoiceproducts as $invoiceproduct) {
        $all_invoiceproduct[] = [
              "product" => $invoiceproduct->{'product'},
               "Amount" => $invoiceproduct->{'amount'},
             
        ];
    }
          return response()->json($all_invoiceproduct, 200);

} catch (\Exception $e) {
    return response()->json([
        'error' => true,
        'message' => $e->getMessage()
    ], 400);
};
    
}




public function getinvoice_topay()
{ try{
  
    $invoiceproducts = @TBInvoice_SalesTotal::all();  
     
foreach($invoiceproducts as $invoiceproduct) {
        $all_invoiceproduct[] = [
                "id" => $invoiceproduct->{'id'},
              "invoice" => $invoiceproduct->{'invoicename'},
               "amount" => $invoiceproduct->{'invoiceamount'},
                "status" => $invoiceproduct->{'invoice_status'},
             
             
        ];
    }
          return response()->json($all_invoiceproduct, 200);

} catch (\Exception $e) {
    return response()->json([
        'error' => true,
        'message' => $e->getMessage()
    ], 400);
};
    
}
public function store_invoiceproducts_APIs(Request $request)
{

 
    try {

     
        $productname = $request->input('productName');
        $productamount = $request->input('ProductAmount');
        $productseller = $request->input('productSeller');
        

        if ($productname == null){
            return response(['error'=>true,'message'=>'Enter  Name']);
        }
        if ($productamount == null){
            return response(['error'=>true,'message'=>'Enter Amount']);
        }

        if ($productseller == null){
            return response(['error'=>true,'message'=>'Enter seller id not found']);
        }
      
        $data = [
            
            'product' => $productname,
            'amount' => $productamount,
            'sellerinvoice_id' => $productseller,
          'status' => 1,
        ];
          TBInvoice_Sales::create($data);
          
 
          return response(['error'=>false,'message'=>'Created Successfully.'], 200);

    } catch (Exception $e){
        return $e->getMessage();
    }
}


public function store_invoicegrandtotal_APIs(Request $request)
{

 
    try {

     
        $name = $request->input('InvoiceName');
        $amount = $request->input('InvoiceAmount');
       
        

        if ($name == null){
            return response(['error'=>true,'message'=>'Enter  Name']);
        }
        if ($amount == null){
            return response(['error'=>true,'message'=>'Enter Amount']);
        }

      
        $data = [
            
            'invoicename' => $name,
            'invoiceamount' => $amount,
            'invoice_status' =>  'NOT PAID',
         
        ];
          TBInvoice_SalesTotal::create($data);
          
           DB::connection("nyisoftechco_invoice_assessment")->table("invoice_sale")
         
         ->where('status', 1)
         ->update(['status' => 2]);
          return response(['error'=>false,'message'=>'Created Successfully.'], 200);

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
        
        $transid =$request->input('invoiceid');
        $usersid = @Session::get('id')?:null;
        $usersphone = @Session::get('phonenumber')?:null;

        $amount = $request->input('amount');
        $phoneNumber = $request->input('phonenumber');
        
    
        $formattedNumber = $this->formatKenyanPhoneNumber($phoneNumber);
        Log::info("Phone number formatted: " . json_encode($formattedNumber));

        $dateTime = Carbon::now();
        Log::info('Request MPESA Payload: ' . json_encode($request->all()));

        $url = 'https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest';
        
        DB::connection("nyisoftechco_invoice_assessment")->table("invoice_grandTotal")
         
         ->where('id', $transid)
         ->update(['invoice_status' => 'PAID']);
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


public function alltransactionapi()
{ try{
  
    $alltransactions = @TBMpesaTransaction::all();  
     $allmessages = [];
foreach($alltransactions as $alltransacts) {
        $allmessages[] = [
              "phonepaid" => $alltransacts->{'BillRefNumber'},
               "amountpaid" => $alltransacts->{'TransAmount'},
             
        ];
    }
          return response()->json($allmessages, 200);

} catch (\Exception $e) {
    return response()->json([
        'error' => true,
        'message' => $e->getMessage()
    ], 400);
};
    
}
}