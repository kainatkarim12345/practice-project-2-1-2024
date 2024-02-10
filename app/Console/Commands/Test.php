<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Notification;
use App\Notifications\DiscountNotification;
use App\Models\User;
use Carbon\Carbon;

class Test extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'role:add';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Role added';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Discount message
        $discountMsg = [
            'title' => 'MEGA SALE',
        ];

        // Get customers
        $customers = User::where('user_role_id', '=', '2')->get();

        foreach ($customers as $customer) {
            // Send notification
            Notification::send($customer, new DiscountNotification($discountMsg));
        }

        $this->info('Discount notifications sent successfully.');
    }
}
