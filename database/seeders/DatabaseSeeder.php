<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. User
        \App\Models\User::create([
            'name' => 'Admin Amikom',
            'email' => 'admin@amikom.ac.id',
            'password' => bcrypt('password'),
        ]);

        // 2. Categories
        $category = \App\Models\Category::create([
            'name' => 'Seminar IT',
            'slug' => 'seminar-it',
        ]);

        $category2 = \App\Models\Category::firstOrCreate([
            'name' => 'Entertainment',
            'slug' => 'entertainment',
        ]);

        $category3 = \App\Models\Category::create([
            'name' => 'Workshop',
            'slug' => 'workshop',
        ]);

        // 3. Events

        \App\Models\Event::create([
            'category_id' => $category2->id,
            'title' => 'Jazz Night 2025',
            'description' => 'Nikmati malam dengan musik jazz.',
            'date' => '2026-05-10 19:00:00',
            'location' => 'Amikom Baru',
            'price' => 50000,
            'stock' => 100,
            'poster_path' => 'posters/event-1.png',
        ]);

        \App\Models\Event::create([
            'category_id' => $category->id,
            'title' => 'Hackathon Developer',
            'description' => 'Asah skill coding kamu!',
            'date' => '2026-05-05 10:00:00',
            'location' => 'Inkubator Amikom',
            'price' => 50000,
            'stock' => 100,
            'poster_path' => 'posters/event-2.png',
        ]);

        \App\Models\Event::create([
            'category_id' => $category->id,
            'title' => 'AI Future Tech Summit',
            'description' => 'Belajar AI dan teknologi masa depan.',
            'date' => '2026-05-01 13:00:00',
            'location' => 'Cinema Unit 6',
            'price' => 50000,
            'stock' => 100,
            'poster_path' => 'posters/event-3.png',
        ]);

        \App\Models\Event::create([
            'category_id' => $category3->id,
            'title' => 'UI/UX Design Workshop',
            'description' => 'Belajar desain aplikasi modern.',
            'date' => '2026-06-01 09:00:00',
            'location' => 'Lab Multimedia',
            'price' => 40000,
            'stock' => 50,
            'poster_path' => 'posters/event-4.png',
        ]);

        \App\Models\Event::create([
            'category_id' => $category2->id,
            'title' => 'E-Sport U-Champ',
            'description' => 'Turnamen game antar mahasiswa.',
            'date' => '2026-06-10 15:00:00',
            'location' => 'Auditorium',
            'price' => 30000,
            'stock' => 200,
            'poster_path' => 'posters/event-5.png',
        ]);

        \App\Models\Event::create([
            'category_id' => $category3->id,
            'title' => 'Mobile App Development',
            'description' => 'Belajar bikin aplikasi Android.',
            'date' => '2026-06-15 10:00:00',
            'location' => 'Lab Programming',
            'price' => 45000,
            'stock' => 80,
            'poster_path' => 'posters/event-6.png',
        ]);
    }
}