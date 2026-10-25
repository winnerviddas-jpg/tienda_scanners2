<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Product::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        Product::create([
            'nombre' => 'Autel MaxiCOM MK808Z-BT',
            'marca' => 'Autel',
            'descripcion' => 'Scanner profesional con 37 funciones de servicio, diagnóstico de todos los sistemas y conexión Bluetooth.',
            'precio' => 450.00,
            'imagen' => 'img/autel.jpg', // Ruta a tu nueva carpeta
            'stock' => 10,
        ]);

        Product::create([
            'nombre' => 'Launch X431 Pros V5.0',
            'marca' => 'Launch',
            'descripcion' => 'Equipo de diagnóstico bidireccional avanzado, codificación de ECU y protocolos CAN FD / DoIP.',
            'precio' => 890.00,
            'imagen' => 'img/launch.jpg', // Ruta a tu nueva carpeta
            'stock' => 5,
        ]);

        Product::create([
            'nombre' => 'Thinkcar Thinkdiag 2',
            'marca' => 'Thinkcar',
            'descripcion' => 'Scanner compacto e inteligente para smartphone, soporta protocolo CAN FD y diagnóstico completo de sistemas.',
            'precio' => 150.00,
            'imagen' => 'img/thinkdiag.jpg', // Ruta a tu nueva carpeta
            'stock' => 20,
        ]);
    }
}