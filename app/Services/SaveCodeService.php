<?php

namespace App\Services;

class SaveCodeService
{

    public static function IDGenerator($table, $model, $trow, $length = 4, $prefix)
    {
          $data = $table::orderBy('id', 'desc')->first();
          if (!$data) {
               $og_length = $length;
               $last_number = '';
          }
          else{
               $code = substr($data->$trow, strlen($prefix)+1);
               $actial_last_number = ($code/1)*1;
               $increment_last_number = $actial_last_number+1;
               $last_number_length = strlen($increment_last_number);
               $og_length = $length - $last_number_length;
               $last_number = $increment_last_number;
          }

          $zeros = "";

          for ($i=0; $i<$og_length; $i++) { 

               $zeros.="0";
          }
          
          $model->$trow = $prefix.$zeros.$last_number;
          $model->save();
    }

}






