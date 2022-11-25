<?php

namespace App\Models;

use App\Traits\HasAuthor;
use Illuminate\Database\Eloquent\Model;
use Unicodeveloper\Paystack\Facades\Paystack;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Options extends Model
{
    use HasFactory;
    use HasAuthor;

    const TABLE = 'options';

    protected $table = self::TABLE;

    protected $fillable = [
        'author_id', 'name', 'value'
     ];


     public static function getOneBranchOption($name, User $author){
        return Options::where('author_id', $author->id())->where('name', $name)->first();
    }

    public static function getOneOption($name){
        return Options::where('name', $name)->first();
    }

    public static function getBranchOption(User $author){

        $options = Options::where('author_id', $author->id)->get();
        
        foreach ($options as $key => $value) {
          if ($value->name == 'collection_commission') {
            $options[$key]->value = (Options::getLatestCommission())->value;
            // todo
            return $options;
          }
        }
  
        return $options;
    }

    public static function putBranchOption($request, User $author){
        if($request->name === 'sub_account') {
            
            $options = ['commission_account_name', 'commission_account_bank', 'commission_account_number', 'subaccount_code'];
            
            $request->request->add([
                "business_name" => $request->commission_account_name,
                "settlement_bank" => $request->commission_account_bank,
                "account_number" => $request->commission_account_number,
                "percentage_charge" => 1,
            ]);

            // dd($request);
            // if any author already created sub account
            // then go for update
            $subaccount_code = Options::getLatest('subaccount_code');

            // dd($subaccount_code);

            if ($subaccount_code) {
                $subaccount_code = $subaccount_code->value;
            }
            
            // dd($subaccount_code);
            if ($subaccount_code) {
                // update sub account
                try {
                $acounts = Paystack::updateSubAccount($subaccount_code);
                } catch (\Exception $e) {
                throw new \Exception($e->getMessage());
                return $e->getMessage();
                }
    
                foreach ($options as $key => $option) {
                if ($option == 'subaccount_code') {
                    $opt = Options::getLatest($option);
                    $optionValue = $subaccount_code;
                } else {
                    $opt = Options::getOneOption($option);
                    $optionValue = $request->$option;
                }
                $opt->name = $option;
                $opt->value = $optionValue;
                $opt->save();
                }
                return $acounts;
            } else {
                // create sub account
                try {
                    $update = Paystack::createSubAccount();
                } catch (\Exception $e) {
                    throw new \Exception($e->getMessage());
                    return $e->getMessage();
                }
    
                $options = ['commission_account_name', 'commission_account_bank', 'commission_account_number', 'subaccount_code'];
                foreach ($options as $key => $option) {
                    if ($option == 'subaccount_code') {
                        $optionValue = $update['data']['subaccount_code'];
                    } else { $optionValue = $request->$option;  }
        
                    Options::create([
                        'author_id' => $author->id,
                        'name' => $option,
                        'value' => $optionValue
                    ]);
                }
                return $update;
            }
            // else if already created
            // else create new
  
            // update part
        } elseif($option = Options::getOneBranchOption($request->name, $author)) {
          // code...
          $option->name = $request->name;
          $option->value = $request->value;
          $option->save();
          return $option;
        }
  
        // create part
        return Options::create([
          'author_id' => $author->id,
          'name' => $request->name,
          'value' => $request->value
        ]);
    }

    public static function getLatestCommission(){
        return $options = Options::where('name', 'collection_commission')->orderBy('updated_at','desc')->first();
    }
      
    public static function getLatest($name){
        return Options::where('name', $name)->latest()->first();
    }

    public static function getLatestCommissionBankDetails(){
        $options = Options::where('name', 'commission_account_bank')->orWhere('name', 'commission_account_number')
        ->orWhere('name', 'commission_account_name')->orderBy('updated_at','desc')->get();
        return $options;
    }
}