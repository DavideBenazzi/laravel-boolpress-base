<?php

use Illuminate\Database\Seeder;
use App\Post;
use App\Comment;
use Faker\Generator as Faker;

class CommentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        //Get post - x3 comments
        $posts = Post::all();
        foreach ($posts as $post) {
            for( $i=0 ; $i < 3 ; $i++ ) {

                //Creazione istanza
                $newComment = new Comment();
    
                //Dati colonne
                $newComment->post_id = $post->id;
                $newComment->author = $faker->userName();
                $newComment->text = $faker->sentence(10);
    
                //Salvare i dati
                $newComment->save();
            }
        }
    }
}
