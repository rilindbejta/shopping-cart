<?php

namespace App\Jobs;

use App\Mail\LowStockNotification;
use App\Models\Product;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class LowStockNotificationJob implements ShouldQueue
{
    use Queueable;

    /**
     * The number of times the job may be attempted.
     *
     * @var int
     */
    public $tries = 3;

    public function __construct(
        public Product $product
    ) {}

    public function handle(): void
    {
        try {
            // Get admin user
            $admin = User::where('email', 'admin@example.com')->first();

            if (!$admin) {
                Log::warning('Admin user not found for low stock notification');
                return;
            }

            Mail::to($admin->email)->send(new LowStockNotification($this->product));

            Log::info('Low stock notification sent', [
                'product_id' => $this->product->id,
                'product_name' => $this->product->name,
                'stock_quantity' => $this->product->stock_quantity,
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to send low stock notification', [
                'product_id' => $this->product->id,
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }
}
