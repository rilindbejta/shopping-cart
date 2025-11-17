<?php

namespace App\Console\Commands;

use App\Mail\DailySalesReport;
use App\Models\User;
use App\Services\OrderService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class DailySalesReportCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sales:daily-report {date?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate and send daily sales report';

    /**
     * Execute the console command.
     */
    public function handle(OrderService $orderService): int
    {
        try {
            // Get date parameter or use today's date
            $date = $this->argument('date') ?? now()->toDateString();

            $this->info("Generating sales report for {$date}...");

            // Get report data
            $reportData = $orderService->getDailySalesReport($date);

            // Get admin user
            $admin = User::where('email', 'admin@example.com')->first();

            if (!$admin) {
                $this->error('Admin user not found');
                Log::error('Admin user not found for daily sales report');
                return Command::FAILURE;
            }

            // Send email
            Mail::to($admin->email)->send(new DailySalesReport($reportData));

            $this->info('Daily sales report sent successfully!');
            $this->line("Total Orders: {$reportData['total_orders']}");
            $this->line("Total Products Sold: {$reportData['total_products_sold']}");
            $this->line("Total Revenue: $" . number_format($reportData['total_revenue'], 2));

            Log::info('Daily sales report sent', [
                'date' => $date,
                'total_orders' => $reportData['total_orders'],
                'total_revenue' => $reportData['total_revenue'],
            ]);

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error('Failed to generate daily sales report: ' . $e->getMessage());
            Log::error('Failed to send daily sales report', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            return Command::FAILURE;
        }
    }
}
