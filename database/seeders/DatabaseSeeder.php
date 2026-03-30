<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserProfile;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Company;
use App\Models\Project;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Cria a Empresa 
        $company = Company::create([
            'name' => 'Christian Diaz Solutions',
            'description' => 'Consultoria em Engenharia de Software',
        ]);

        // Cria o Projeto vinculado à Empresa
        $project = Project::create([
            'company_id' => $company->id,
            'name' => 'Sistema de Triagem Care Plus',
            'description' => 'Desenvolvimento de automação com n8n e Java',
        ]);

        // Projeto 2
        Project::create([
            'company_id' => $company->id,
            'name' => 'Migração de Dados KPMG',
            'description' => 'Tratamento de bases SQL Server',
        ]);

        // Projeto 3 
        Project::create([
            'company_id' => $company->id,
            'name' => 'Portal de Chamados Stefanini',
            'description' => 'Interface em Vue 3 e Inertia',
        ]);

        // Usuário de teste
        $user = User::create([
            'name' => 'Administrador',
            'email' => 'admin@admin.com',
            'password' => Hash::make('admin123'), 
        ]);

        // CRIA O PERFIL VINCULADO AO USUÁRIO (1:1)
        // Usamos a relação para preencher o 'user_id' automaticamente
        $user->profile()->create([
            'phone' => '11999999999',
            'position' => 'Software Engineer / Scrum Master',
        ]);

        $this->command->info('Usuário e Perfil 1:1 de Christian criados com sucesso!');

    }
}
