<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $json = File::get(path: 'database/json/empolyee.json');
        $array = collect(json_decode($json));


        $array->each(function ($single) {
            Employee::create([
                'name' => $single->name,
                'email' => $single->email,
                'role' => $single->role,
                'age' => $single->age,
                'city' => $single->city,
                'image_name' => $single->image_name

            ]);
        });
    }
}
