<?php

namespace App\Console\Commands\Fetch;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Config;
use JetBrains\PhpStorm\NoReturn;

#[Signature('app:fetch:incomes')]
#[Description('Fetching incomes data from a remote server using http API')]
class FetchIncomesDataCommand extends Command implements FetchCommand
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
            endpoint: "incomes",
            db_table: "incomes",
            queryParams: [
                "key" => Config::string("services.wb_api.key"),
                "page" => 1,
                "dateFrom" => self::EARLY_BEFORE,
                "dateTo" => self::LATER_AFTER,
            ],
        );
    }
}
