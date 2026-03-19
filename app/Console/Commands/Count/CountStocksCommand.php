<?php

namespace App\Console\Commands\Count;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use JetBrains\PhpStorm\NoReturn;

#[Signature("app:count:stocks")]
#[Description("Prints fetched stocks count")]
class CountStocksCommand extends Command implements CountCommand
{
    use IsCountCommand;

    #[NoReturn]
    public function handle(): void
    {
        $this->logCount("stocks");
    }
}
