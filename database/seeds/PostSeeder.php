<?php

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Tag;
use App\Models\Like;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = App\Models\Tag::all();
        $users = App\User::pluck('id')->all();
        factory(Post::class, 200)
            ->create()
            ->each(function ($post) use ($tags, $users) {
                $post->tags()->attach(
                    $tags->random(rand(1, 3))->pluck('id')->toArray()
                );
                for ($count = 0; $count < rand(10, 200); $count++) {
                    $post->likes()->create([
                        'user_id' => $users[array_rand($users)],
                    ]);
                }
            });
    }
}
