<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class table extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rename:table {from : table name to be renamed} {to : new table name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will rename the table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $from = $this->argument("from");
        $to = $this->argument("to");

        try {
            DB::statement("Alter table $from RENAME TO $to");
            $this->info("Table $from has renamed with $to");
        } catch (QueryException $e) {
            $this->error("Error in renaming table: " . $e->getMessage());
        }
    }
}
