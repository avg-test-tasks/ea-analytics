<?php

namespace App\Console\Commands;

use Exception;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use JetBrains\PhpStorm\NoReturn;

#[Signature("app:fetch:orders")]
#[Description("Fetching orders data from a remote server using http API")]
class FetchOrdersDataCommand extends Command
{
    /**
     * @throws ConnectionException
     */
    #[NoReturn]
    public function handle(): void
    {
        $body = Cache::remember("orders_batch_1",
            ttl: 600,
            callback: fn() => Http::withQueryParameters([
                "dateFrom" => "2000-01-01",
                "dateTo" => "3000-01-01",
                "key" => Config::string("services.wb_api.key"),
                "page" => 1,
            ])->get("http://109.73.206.144:6969/api/orders")->json()
        );
        $this->info("Fetched order batch: #1");
        DB::table("orders")->insert($body["data"]);

        while ($body["meta"]["current_page"] < $body["meta"]["last_page"]) {
            $nextPage = $body["meta"]["current_page"] + 1 ?? -1;
            $body = Cache::remember("orders_batch_$nextPage",
                ttl: 600,
                callback: fn() => Http::retry(3, function (int $attempt, Exception $e) {
                    if ($e instanceof RequestException && $e->response->header("Retry-After")) {
                        return (int) $e->response->header("Retry-After") * 1000;
                    }
                    return 5 * 1000;
                })->withQueryParameters([
                    "dateFrom" => "2000-01-01",
                    "dateTo" => "3000-01-01",
                    "key" => Config::string("services.wb_api.key"),
                    "page" => $nextPage,
                ])->get("http://109.73.206.144:6969/api/orders")->json()
            );
            $this->info("Fetched order batch: #$nextPage");
            DB::table("orders")->insert($body["data"]);

            gc_collect_cycles();
        }
    }
}
