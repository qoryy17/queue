<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Counter\CounterModel;
use App\Models\Officer\OfficerModel;
use Illuminate\Support\Facades\Hash;
use App\Models\Configure\SettingModel;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        OfficerModel::create([
            'nip' => '123456789',
            'name' => 'Qori Chairawan',
            'position' => 'PPPK - Operator Layanan Operasional',
            'block' => 'N'
        ]);

        User::create([
            'name' => 'Qori Chairawan',
            'email' => 'qorichairawan17@gmail.com',
            'password' => Hash::make('123'),
            'officer_id' => '1',
            'role' => \App\Enum\RolesEnum::ADMIN->value,
            'block' => 'N'
        ]);

        SettingModel::create([
            'institution' => 'Mahkamah Agung Republik Indonesia',
            'eselon' => 'Direktorat Jenderal Badan Peradilan Umum',
            'jurisdiction' => 'Pengadilan Tinggi Medan',
            'unit' => 'Pengadilan Negeri Lubuk Pakam',
            'address' => 'Jalan Jenderal Sudirman No. 58 Lubuk Pakam',
            'province' => 'Sumatera Utara',
            'city' => 'Kabupaten Deli Serdang',
            'post_code' => '20517',
            'email' => 'pnlubukpakam@yahoo.co.id',
            'website' => 'http://www.pn-lubukpakam.go.id',
            'contact' => '0000',
            'logo' => '-',
            'license' => '-'
        ]);
    }
}
