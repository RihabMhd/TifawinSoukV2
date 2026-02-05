<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class FournisseurSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('fournisseurs')->insert([
            [
                'name' => 'Fournisseur Alpha',
                'email' => 'alpha@fournisseurs.com',
                'phone' => '0612345678',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Fournisseur Beta',
                'email' => 'beta@fournisseurs.com',
                'phone' => '0623456789',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'Fournisseur Gamma',
                'email' => 'gamma@fournisseurs.com',
                'phone' => '0634567890',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
    }
}
