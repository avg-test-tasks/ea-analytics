<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\NoReturn;

#[Signature("app:count:stocks")]
#[Description("Prints fetched stocks count")]
class CountStocksCommand extends Command
{
    #[NoReturn]
    public function handle(): void
    {
        $this->info("Fetched stocks: " . DB::table("stocks")->count() . PHP_EOL);
    }
}
