<?php

namespace App\Console\Commands\Fetch;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use JetBrains\PhpStorm\NoReturn;

#[Signature('app:fetch:stocks')]
#[Description('Fetching stocks data from a remote server using http API')]
class FetchStocksDataCommand extends Command implements FetchCommand
{
    use IsFetchCommand;

    public function __construct()
    {
        parent::__construct();
        $this->initAsFetchCommand();
    }

    #[NoReturn]
    public function handle(): void
    {
        $this->fetch(
            endpoint: "stocks",
            db_table: "stocks",
            queryParams: [
                "key" => Config::string("services.wb_api.key"),
                "page" => 1,
                "dateFrom" => now()->format("Y-m-d"),
            ],
        );
    }
}
