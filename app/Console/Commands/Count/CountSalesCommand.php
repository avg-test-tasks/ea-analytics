<?php

namespace App\Console\Commands\Count;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use JetBrains\PhpStorm\NoReturn;

#[Signature("app:count:sales")]
#[Description("Prints fetched sales count")]
class CountSalesCommand extends Command
{
    use IsCountCommand;

    #[NoReturn]
    public function handle(): void {
        $this->logCount("sales");
    }
}
