<?php

namespace App\Console\Commands\Count;

use Illuminate\Support\Facades\DB;

trait IsCountCommand
{
    public function count(string $db_table): int {
        return DB::table($db_table)->count();
    }

    public function logCount(string $db_table): void{
        $this->info("Total fetched " . $this->count($db_table) . "($db_table)" . PHP_EOL);
    }
}
