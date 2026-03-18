<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\NoReturn;

#[Signature("app:count:sales")]
#[Description("Prints fetched sales count")]
class CountSalesCommand extends Command
{
    #[NoReturn]
    public function handle(): void
    {
        $this->info("Fetched sales: " . DB::table("sales")->count() . PHP_EOL);
    }
}
