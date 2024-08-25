<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Faker\Factory;

class StudentsSeeder extends Seeder
{
    public function run()
    {
        //usa biblioteca para poder criar infos aleatorias e popular o banco de dados
        $faker= Factory::create('pt_BR');
        for($i=0;$i<=10;$i++){
            $dataStudent = [
                'fullName'=>$faker->firstName(),
                'email'=>$faker->email(),
                'cpf'=>$faker->numberBetween(1,20000),
                'phone'=>$faker->phoneNumber(),
                'street'=>$faker->streetName(),
                'city'=>$faker->city(),
                'state'=>$faker->country(),
                'cep'=>$faker->postcode(),
                'address_number'=>$faker->numberBetween(1,2000),
                'photo'=>$faker->shuffleString('skadwkemdaoswkrmasodasdwoe')
            ];
            $this->db->table('student')->insert($dataStudent);
        }
    }
}
