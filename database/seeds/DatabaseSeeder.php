<?php

use App\Models\Products;
use App\Models\ProductsUpdates;
use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => "User",
            'email' => 'user@teste.com',
            'password' => Hash::make('12345678'),
        ]);

        Products::create([
            'user_id' => 1,
            'name' => 'Tijolos 9x19x29 (8 Furos)',
            'description' => 'Tijolos cerâmicos de alta qualidade, medidas exatas padrão INMETRO, sem empenos, baixa absorção de umidade e grande resistência, temos também meio tijolo para evitar cortes, e canaletas para cintamento de paredes , economizando tempo, substituindo utilização de tábuas e oferecendo uma ótima estética para sua obra',
            'amount' => 50,
            'minimum' => 100
        ]);

        Products::create([
            'user_id' => 1,
            'name' => 'Tijolos 9x19x29 (8 Furos) 1/2',
            'description' => 'Tijolo meio para evitar cortes, e canaletas para cintamento de paredes , economizando tempo, substituindo utilização de tábuas e oferecendo uma ótima estética para sua obra',
            'amount' => 10,
            'minimum' => 50
        ]);

        Products::create([
            'user_id' => 1,
            'name' => 'Cimento Votorantim Todas As Obras 50kg',
            'description' => 'O Cimento Todas as Obras 50kg da Votorantim é um Cimento  de alta qualidade, que atende aos requisitos técnicos das normas ABNT, sendo indicada para a preparação de diversos tipos de obras, reboco, concreto convencional, contra pisos e lajes.O único com propriedades de Silicatos de cálcio, alumínio e ferro, trazendo maior resistência, aderência, elasticidade e economia.',
            'amount' => 20,
            'minimum' => 70
        ]);

        ProductsUpdates::create([
            'user_id' => 1,
            'product_id' => 1,
        ]);

        ProductsUpdates::create([
            'user_id' => 1,
            'product_id' => 1,
        ]);

        ProductsUpdates::create([
            'user_id' => 1,
            'product_id' => 2,
        ]);

    }
}
