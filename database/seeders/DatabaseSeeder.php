<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Customer;
use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@impactguru.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Staff User',
            'email' => 'staff@impactguru.com',
            'password' => Hash::make('password'),
            'role' => 'staff',
        ]);

        $customers = [
            ['name' => 'John Doe', 'email' => 'john@example.com', 'phone' => '+1-555-0101', 'address' => '123 Main St, New York, NY 10001'],
            ['name' => 'Jane Smith', 'email' => 'jane@example.com', 'phone' => '+1-555-0102', 'address' => '456 Oak Ave, Los Angeles, CA 90001'],
            ['name' => 'Bob Johnson', 'email' => 'bob@example.com', 'phone' => '+1-555-0103', 'address' => '789 Pine Rd, Chicago, IL 60601'],
            ['name' => 'Alice Brown', 'email' => 'alice@example.com', 'phone' => '+1-555-0104', 'address' => '321 Elm St, Houston, TX 77001'],
            ['name' => 'Charlie Wilson', 'email' => 'charlie@example.com', 'phone' => '+1-555-0105', 'address' => '654 Cedar Ln, Phoenix, AZ 85001'],
        ];

        foreach ($customers as $customerData) {
            $customer = Customer::create($customerData);
            $statuses = ['pending', 'completed', 'cancelled'];
            for ($i = 0; $i < rand(1, 5); $i++) {
                Order::create([
                    'customer_id' => $customer->id,
                    'order_number' => Order::generateOrderNumber(),
                    'amount' => rand(100, 10000) / 10,
                    'status' => $statuses[array_rand($statuses)],
                    'order_date' => now()->subDays(rand(0, 60)),
                ]);
            }
        }
    }
}
