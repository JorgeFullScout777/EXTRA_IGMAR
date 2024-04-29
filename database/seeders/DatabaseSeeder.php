<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{

    public function run()
    {

        DB::table('roles')->insert([
            ['name' => 'admin'],
            ['name' => 'user'],
        ]);

        DB::table('users')->insert([
            ['name' => 'JorgeFullScout',  'email' => 'jorgefullscout@gmail.com',  'password' => Hash::make('password'), 'role_id' => 1],
            ['name' => 'Diana',  'email' => 'diana.itzel@gmail.com',  'password' => Hash::make('password'), 'role_id' => 2],
            ['name' => 'Erick',  'email' => 'laloelrick@gmail.com',  'password' => Hash::make('password'), 'role_id' => 2],
        ]);

        // DB::table('communities')->insert([
        //     ['name' => 'Laravel Community',  'description' => 'The best PHP framework',  'user_id' => 1],
        //     ['name' => 'Vue Community',  'description' => 'The best JS framework',  'user_id' => 2],
        // ]);

        // DB::table('channels')->insert([
        //     ['name' => 'Laravel Channel',  'description' => 'Descripcion del canal 1', 'user_id' => 1],

        //     ['name' => 'Vue Channel',  'description' => 'Descripcion del canal 1', 'user_id' => 2],
        // ]);

        // DB::table('posts')->insert([
        //     ['title' => 'Post 1 comunidad laravel',  'content' => 'Contenido del post 1',  'channel_id' => 1, 'user_id' => 1],
        //     ['title' => 'Post 2 comunidad laravel',  'content' => 'Contenido del post 2',  'channel_id' => 1, 'user_id' => 1],

        //     ['title' => 'Post 1 comunidad vue',  'content' => 'Contenido del post 1',  'channel_id' => 2, 'user_id' => 2],
        //     ['title' => 'Post 2 comunidad vue',  'content' => 'Contenido del post 2',  'channel_id' => 2, 'user_id' => 2],
        // ]);

        // DB::table('comments')->insert([
        //     ['content' => 'Contenido del comentario 1 comunidad laravel',  'post_id' => 1, 'user_id' => 1],
        //     ['content' => 'Contenido del comentario 2 comunidad laravel',  'post_id' => 1, 'user_id' => 2],

        //     ['content' => 'Contenido del comentario 1 comunidad vue',  'post_id' => 3, 'user_id' => 2],
        //     ['content' => 'Contenido del comentario 2 comunidad vue',  'post_id' => 4, 'user_id' => 1],
        // ]);

        // DB::table('messages')->insert([
        //     ['content' => 'Contenido del mensaje 1',  'user_id' => 1, 'channel_id' => 1],
        //     ['content' => 'Contenido del mensaje 2',  'user_id' => 2, 'channel_id' => 2],

        //     ['content' => 'Contenido del mensaje 1',  'user_id' => 2, 'channel_id' => 3],
        //     ['content' => 'Contenido del mensaje 2',  'user_id' => 1, 'channel_id' => 4],
        // ]);

        // DB::table('expulsions')->insert([
        //     ['user_id' => 1,  'channel_id' => 2],
        // ]);
    }
}
