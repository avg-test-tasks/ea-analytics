<?php

namespace App\Console\Commands\Fetch;

use Exception;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

trait IsFetchCommand
{
    private const string EARLY_BEFORE = "2000-01-01";
    private const string LATER_AFTER = "3000-01-01";

    private readonly string $url;
    private readonly int $cache_ttl;
    private readonly int $default_timeout;
    private function initAsFetchCommand(): void
    {
        $this->url = Config::string("services.wb_api.host") . ":" . Config::string("services.wb_api.port") . "/"
            . Config::string("services.wb_api.uri");
        $this->cache_ttl = 600;
        $this->default_timeout = 5;
    }

    /**
     * @param string $endpoint
     * @param string $db_table
     * @param array{
     *     key: string,
     *     page: int,
     *     limit?: ?int,
     *     dateFrom: string,
     *     dateTo?: ?string,
     * } $queryParams
     * @return void
     */
    public function fetch(
        string $endpoint,
        string $db_table,
        array  $queryParams = [],
    ): void
    {
        do {
            $nextPage = ($body["meta"]["current_page"] ?? 0) + 1;
            $body = Cache::remember("{$endpoint}_batch_$nextPage",
                ttl: $this->cache_ttl,
                callback: fn() => Http::retry(3, function (int $attempt, Exception $e) {
                    if ($e instanceof RequestException && $e->response->header("Retry-After")) {
                        return (int)$e->response->header("Retry-After") * 1000;
                    }
                    return $this->default_timeout * 1000;
                })->withQueryParameters($queryParams)
                    ->get("$this->url/$endpoint")
                    ->json()
            );
            $fetched = count($body["data"]);
            $this->info("Fetched $endpoint batch #$nextPage of size {$fetched}");
            DB::table($db_table)->insert($body["data"]);
            $queryParams["page"] += 1;

            // Added to manually collect garbage
            // Mandatory (?) to avoid out-of-memory error
            gc_collect_cycles();
        } while ($body["meta"]["current_page"] < $body["meta"]["last_page"]);
    }

}
