<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class StudentSeeder extends Seeder {
    public function run() {
        $db = db_connect();
        $builder = $db->table('students');
        for ($i = 0; $i < 500; $i++) {
            $builder->insert($this->generateData());
        }
    }

    private function generateData() {
        $faker = \Faker\Factory::create('ms_MY');
        return [
            'name' => $faker->name, 'email' => $faker->email, 'mykad' => $faker->myKadNumber,
            'phone' => $faker->phoneNumber, 'created_at' => date("Y-m-d H:i:s"),
        ];
    }
}
