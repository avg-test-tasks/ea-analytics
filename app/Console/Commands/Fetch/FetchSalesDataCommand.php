<?php

namespace App\Console\Commands\Fetch;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use JetBrains\PhpStorm\NoReturn;

#[Signature("app:fetch:sales")]
#[Description("Fetching sales data from a remote server using http API")]
class FetchSalesDataCommand extends Command implements FetchCommand
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
            endpoint: "sales",
            db_table: "sales",
            queryParams: [
                "key" => Config::string("services.wb_api.key"),
                "page" => 1,
                "dateFrom" => self::EARLY_BEFORE,
                "dateTo" => self::LATER_AFTER,
            ]
        );
    }
}
