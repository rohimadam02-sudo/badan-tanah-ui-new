<?php

namespace Database\Seeders;

use App\Models\SocialMedia;
use Illuminate\Database\Seeder;

class SocialMediaSeeder extends Seeder
{
    public function run(): void
    {
        $defaults = SocialMedia::getDefaultIcons();
        
        foreach ($defaults as $data) {
            SocialMedia::updateOrCreate(
                ['nama' => $data['nama']],
                $data
            );
        }
    }
}