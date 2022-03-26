<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run()
    {
        Page::create([
            'title'     => 'About Us',
            'slug'      => 'about',
            'body'      => 'Edit it from Dashboard!',
        ]);

        Page::create([
            'title'     => 'Contact Us',
            'slug'      => 'contact',
            'body'      => 'Edit it from Dashboard!',
        ]);

        Page::create([
            'title'     => 'Terms & Conditions',
            'slug'      => 'terms',
            'body'      => 'Edit it from Dashboard!',
        ]);

        Page::create([
            'title'     => 'Privacy Policy',
            'slug'      => 'privacy',
            'body'      => 'Edit it from Dashboard!',
        ]);
    }
}
