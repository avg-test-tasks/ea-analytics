<?php

namespace App\Console\Commands\Count;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use JetBrains\PhpStorm\NoReturn;

#[Signature("app:count:incomes")]
#[Description("Prints fetched incomes count")]
class CountIncomesCommand extends Command implements CountCommand
{
    use IsCountCommand;

    #[NoReturn]
    public function handle(): void
    {
        $this->logCount("incomes");
    }
}
