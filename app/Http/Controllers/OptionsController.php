<?php

namespace App\Http\Controllers;

use App\Models\Options;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OptionsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function getOneBranchOption(Request $request){
        $branch = Auth::user();
        $status = false;
        $text = "Option not found";
        
        if ($option = Options::getOneBranchOption($request->name, $branch)){ 
            $text = $option; $status = true;
        }
        return response()->json(['status' => $status, 'text' => $text]);
    }

    public function getBranchOption(){
        $branch = Auth::user();
        $status = false;
        $options = Options::getBranchOption($branch);
        
        if (sizeof($options)){ 
            $status = true;
        }
        return response()->json(['status' => $status, 'text' => $options]);
    }
  
    public function putBranchOption(Request $request){
        $branch = Auth::user();
        $status = false;
        $text = "Option Name Not Valid";
        
        $optionName = array('smsbalanceapi', 'collection_commission', 'smsapi', 'sub_account');

        if (in_array($request->name, $optionName) ){

            $text = Options::putBranchOption($request, $branch);
            $text = $text ? "Created successfully!" : $text;
            $status = true;
        }
        return response()->json(['status' => $status, 'text' => $text]);
    }

    public function banks(){
        $string = file_get_contents("https://api.paystack.co/bank");
        $obj = json_decode($string);
        $banks = [];
        foreach ($obj->data as $key => $bank) {
          $banks[] = (object) array('text' => $bank->name, 'value' => $bank->name);
        }
        // dd($banks);
        return $banks;
      }
}