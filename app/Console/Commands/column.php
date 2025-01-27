<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class column extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:column {table : table name} {column_name : name of column want to add} {type : data type of column eg. string, int,flaot} {default? : give the default value}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will add a new column to a particular table ';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $table = $this->argument('table');
        $column = $this->argument('column_name');
        $type = $this->argument('type');
        $default = $this->argument('default');

        $default_value = $default !== null ? "DEFAULT $default" : null;

        try {
            DB::statement("Alter table $table ADD $column $type $default_value");
            $this->info("$column has been added to $table");
        } catch (QueryException $e) {
            $this->error("Error in adding column: " . $e->getMessage());
        }
    }
}
