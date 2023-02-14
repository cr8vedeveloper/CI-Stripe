<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CurrenciesSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'name' => 'AUD/JPY',
                'order' => 1,
            ],
            [
                'id' => 2,
                'name' => 'AUD/NZD',
                'order' => 2,
            ],
            [
                'id' => 3,
                'name' => 'AUD/USD',
                'order' => 3,
            ],
            [
                'id' => 4,
                'name' => 'CAD/JPY',
                'order' => 4,
            ],
            [
                'id' => 5,
                'name' => 'CHF/JPY',
                'order' => 5,
            ],
            [
                'id' => 6,
                'name' => 'EUR/AUD',
                'order' => 6,
            ],
            [
                'id' => 7,
                'name' => 'EUR/GBP',
                'order' => 7,
            ],
            [
                'id' => 8,
                'name' => 'EUR/JPY',
                'order' => 8,
            ],
            [
                'id' => 9,
                'name' => 'EUR/USD',
                'order' => 9,
            ],
            [
                'id' => 10,
                'name' => 'GBP/AUD',
                'order' => 10,
            ],
            [
                'id' => 11,
                'name' => 'GBP/JPY',
                'order' => 11,
            ],
            [
                'id' => 12,
                'name' => 'GBP/USD',
                'order' => 12,
            ],
            [
                'id' => 13,
                'name' => 'NZD/JPY',
                'order' => 13,
            ],
            [
                'id' => 14,
                'name' => 'NZD/USD',
                'order' => 14,
            ],
            [
                'id' => 15,
                'name' => 'USD/CAD',
                'order' => 15,
            ],
            [
                'id' => 16,
                'name' => 'USD/CHF',
                'order' => 16,
            ],
            [
                'id' => 17,
                'name' => 'USD/JPY',
                'order' => 17,
            ],
            [
                'id' => 18,
                'name' => 'GOLD',
                'order' => 18,
            ],
            [
                'id' => 19,
                'name' => 'BITCOIN',
                'order' => 19,
            ],
        ];

        $this->db->table('currencies')->insertBatch($data);
    }
}