<?php

namespace App\Console\Commands\Fetch;

interface FetchCommand
{
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
        array $queryParams = [],
    ): void;
}
