<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use App\User;
use Schema;
use DB;
use Doctrine\DBAL\Driver\PDOMySql\Driver;
use App\a_Tables;

class PagesController extends Controller
{

      public function showAll($link)
      {

          // $tables = DB::select('SHOW TABLES');
          // $allTables = [];
          // foreach ($tables as $t) {
          //       $allTables[] = $t->Tables_in_alpha_cms;
          // }

          $a_table = a_Tables::where('slug', $link)->first();

          if ($a_table){

              $conv = "\App\\".$a_table->module_name;
              $allData = $conv::paginate(8);
              //$keys = [];
              $columns = Schema::getColumnListing($a_table->table);

              // foreach ($columns as $column) {
              //       $c_type = Schema::getColumnType($table , $column);
              //       $keys[$column] = $c_type;
              // }

              return view("blades.viewAll" , ["columns" => $columns , "all" => $allData , "p_name" => $a_table->link_name]);

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
