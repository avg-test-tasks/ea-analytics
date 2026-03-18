<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

#[Signature('app:count:orders')]
#[Description('Prints fetched orders count')]
class CountOrdersCommand extends Command
{
    /**
     *
     */
    public function handle(): void
    {
        $this->info("Fetched orders: " . DB::table("orders")->count() . PHP_EOL);
    }
}
