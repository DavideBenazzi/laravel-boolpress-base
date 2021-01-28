<?php

use Illuminate\Database\Seeder;
use App\Post;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        //ATTENZIONE! SOLO SE VOGLIAMO SOSTITUIRE TUTTI I DATI DI PRIMA!
        // Post::truncate(); 

        //FAKER
        for ( $i=0 ; $i < 10 ; $i++ ) {
            
            $title = $faker->text(50);

            $newPost = new Post();

            $newPost->title = $title;
            $newPost->body = $faker->paragraphs(2 , true);
            $newPost->slug = Str::slug($title , '-');

            $newPost->save();
        }


        /**
         * Basic Way
         */
        // $posts = [
        //     [
        //         'title' => 'Lorem',
        //         'body' => 'Ipsum lorem ipsum lorem ipsum',
        //     ],
        //     [
        //         'title' => 'Ciao',
        //         'body' => 'Ciao ciao ciao ciao ciao',
        //     ],
        //     [
        //         'title' => 'Lol',
        //         'body' => 'Lolol lololol lololol',
        //     ],
        // ];
        // foreach ($posts as $post) {

        //     //Creazione istanza da modello
        //     $newPost = new Post;

        //     //popolazione properties dell'istanza col db
        //     $newPost->title = $post['title'];
        //     $newPost->body = $post['body'];
        //     $newPost->slug = Str::slug($post['title'] , '-');

        //     //Salvataggio record (modello) nel db
        //     $newPost->save();
        // }
    }
}
