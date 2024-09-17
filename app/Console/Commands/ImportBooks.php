<?php

namespace App\Console\Commands;

use App\Models\Book;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ImportBooks extends Command
{
    protected $signature = 'import:books {count=10}';

    protected $description = 'Import books basic';

    public function handle()
    {
        try {
            // Lay so luong muon them tu tham so count, mac dinh = 10
            $count = $this->argument('count');

            Book::factory($count)->create();

            $this->info("$count books imported successfully!");
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
