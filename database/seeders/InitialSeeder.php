<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InitialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void{
        
        // 1. Cria uma Empresa
        $company = \App\Models\Company::create(['name' => 'Empresa Teste Diaz']);

        // 2. Cria um Projeto para essa empresa
        $project = $company->projects()->create(['name' => 'Projeto ServiceHub Alpha']);

        // 3. Cria um Usuário de teste
        $user = \App\Models\User::create([
            'name' => 'Christian Diaz',
            'email' => 'admin@teste.com',
            'password' => bcrypt('12345678'),
        ]);

        // 4. Cria o Perfil para esse usuário (1:1)
        $user->profile()->create([
            'phone' => '11999999999',
            'position' => 'Engenheiro de Software',
        ]);
    }
}
