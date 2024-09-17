<?php

namespace App\Console\Commands;

use App\Models\Book;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CleanUpCovers extends Command
{
    protected $signature = 'clean-up-covers';
    protected $description = 'Remove all cover images do not use';

    public function handle()
    {
        $path = Storage::path('covers');

        $allImageDB = Book::pluck('cover_image');

        $allImageStorage = File::files($path);

        try {

            foreach ($allImageStorage as $imgStorage) {
                $imageName = 'covers/' . $imgStorage->getFilename();

                if (!in_array($imageName, $allImageDB->toArray())) {
                    Storage::delete($imageName);
                    $this->info($imageName . ' removed');
                }
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
