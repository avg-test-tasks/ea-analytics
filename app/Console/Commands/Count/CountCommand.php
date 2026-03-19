<?php

namespace App\Console\Commands\Count;

interface CountCommand
{
    public function count(string $db_table): int;

    public function logCount(string $db_table): void;
}
