<?php
namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    public function run()
    {
        Plan::create([
            'name' => 'Basic',
            'slug' => 'basic',
            'price' => 500.00,
            'billing_period' => 'monthly',
            'description' => 'Basic features + profile updates'
        ]);
        Plan::create([
            'name' => 'Premium',
            'slug' => 'premium',
            'price' => 1000.00,
            'billing_period' => 'monthly',
            'description' => 'All features + admin settings access'
        ]);
    }
}