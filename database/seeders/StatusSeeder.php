<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $statuses = [
            [
                'id'   => 1,
                'name' => 'New',
            ],
            [
                'id'   => 2,
                'name' => 'Processing',
            ],
            [
                'id'   => 3,
                'name' => 'Approved',
            ],
            [
                'id'   => 4,
                'name' => 'Rejected',
            ],
            [
                'id'   => 5,
                'name' => 'Completed',
            ],
        ];

        Status::insert($statuses);
    }
}
