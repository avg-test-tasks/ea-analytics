<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\NoReturn;

#[Signature("app:count:incomes")]
#[Description("Prints fetched incomes count")]
class CountIncomesCommand extends Command
{
    #[NoReturn]
    public function handle(): void
    {
        $this->info("Fetched sales: " . DB::table("incomes")->count() . PHP_EOL);
    }
}
