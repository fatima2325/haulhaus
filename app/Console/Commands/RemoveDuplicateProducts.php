<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class RemoveDuplicateProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:remove-duplicate-products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove duplicate products from database (keeps first occurrence of each name+category combination)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Removing duplicate products...');
        
        $duplicates = Product::select('name', 'category')
            ->groupBy('name', 'category')
            ->havingRaw('COUNT(*) > 1')
            ->get();
        
        $removed = 0;
        
        foreach ($duplicates as $duplicate) {
            // Get all products with this name and category
            $products = Product::where('name', $duplicate->name)
                ->where('category', $duplicate->category)
                ->orderBy('id')
                ->get();
            
            // Keep the first one, delete the rest
            if ($products->count() > 1) {
                $toDelete = $products->skip(1);
                foreach ($toDelete as $product) {
                    $product->delete();
                    $removed++;
                }
                $this->info("Removed duplicates for: {$duplicate->name} ({$duplicate->category})");
            }
        }
        
        if ($removed === 0) {
            $this->info('No duplicates found.');
        } else {
            $this->info("Removed {$removed} duplicate product(s).");
        }
        
        return 0;
    }
}
