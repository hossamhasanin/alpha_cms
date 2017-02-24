<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\User;
use Schema;
use DB;
use Doctrine\DBAL\Driver\PDOMySql\Driver;

class PagesController extends Controller
{

      public function showAll($table)
      {

          $tables = DB::select('SHOW TABLES');
          $allTables = [];
          foreach ($tables as $t) {
                $allTables[] = $t->Tables_in_alpha_cms;
          }

          if ($table == "users"){

              //$conv = "\App\\".ucfirst($table);
              $allData = \App\User::paginate(8);
              $keys = [];
              $columns = Schema::getColumnListing($table);

              foreach ($columns as $column) {
                    $c_type = Schema::getColumnType($table , $column);
                    $keys[$column] = $c_type;
              }

              return view("blades.viewAll" , ["columns" => $columns , "all" => $allData , "p_name" => $table]);



          } elseif (in_array($table , $allTables) && ($table == "migrations" && $table == "password_resets")) {

              $conv = "\App\\".ucfirst($table);
              $allData = $conv::get();
              $keys = [];
              $columns = Schema::getColumnListing($table);

              foreach ($columns as $column) {
                    $c_type = Schema::getColumnType($table , $column);
                    $keys[$column] = $c_type;
              }

              return view("blades.viewAll" , ["columns" => $columns , "all" => $allData , "p_name" => $table]);

          }else {
              echo "None , انت جيت غلط";
          }

      }

}





//$columns = DB::connection()->getDoctrineSchemaManager()->listTableColumns('users');
//$columns = DB::connection()->getDoctrineColumn('users', 'id')->getType()->getName();
//$columns = Schema::getColumnType($table , "id");
// $tables = DB::select('SHOW TABLES');
// echo $tables[0]->Tables_in_alpha_cms;
