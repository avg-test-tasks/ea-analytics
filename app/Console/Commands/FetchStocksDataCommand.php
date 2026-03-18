<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use JetBrains\PhpStorm\NoReturn;

#[Signature('app:fetch:stocks')]
#[Description('Fetching incomes data from a remote server using http API')]
class FetchStocksDataCommand extends Command
{
    #[NoReturn]
    public function handle(): void
    {
        $body = Cache::remember("stocks_batch_1",
            ttl: 600,
            callback: fn() => Http::withQueryParameters([
                "dateFrom" => now()->format("Y-m-d"),
                "key" => Config::string("services.wb_api.key"),
                "page" => 1,
            ])->get("http://109.73.206.144:6969/api/stocks")->json()
        );
        $this->info("Fetched stocks batch: #1");
        DB::table("stocks")->insert($body["data"]);

        while ($body["meta"]["current_page"] < $body["meta"]["last_page"]) {
            $nextPage = $body["meta"]["current_page"] + 1 ?? -1;
            $body = Cache::remember("stocks_batch_$nextPage",
                ttl: 600,
                callback: fn() => Http::retry(3, function (int $attempt, Exception $e) {
                    if ($e instanceof RequestException && $e->response->header("Retry-After")) {
                        return (int) $e->response->header("Retry-After") * 1000;
                    }
                    return 5 * 1000;
                })->withQueryParameters([
                    "dateFrom" => now()->format("Y-m-d"),
                    "key" => Config::string("services.wb_api.key"),
                    "page" => $nextPage,
                ])->get("http://109.73.206.144:6969/api/stocks")->json()
            );
            $this->info("Fetched stocks batch: #$nextPage");
            DB::table("stocks")->insert($body["data"]);

            gc_collect_cycles();
        }
    }
}
