<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class AuthorPublisherBookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $defaultPublicImagePath = public_path('images/default_cover.png');

        $storedDefaultCoverPath = 'covers/default_cover.png';

        if (!Storage::disk('public')->directoryExists('covers')) {
            Storage::disk('public')->makeDirectory('covers');
        }

        if (!Storage::disk('public')->exists($storedDefaultCoverPath)) {
            if (File::exists($defaultPublicImagePath)) {
                Storage::disk('public')->put(
                    $storedDefaultCoverPath, 
                    File::get($defaultPublicImagePath)
                );
            } else {
                Storage::disk('public')->put($storedDefaultCoverPath, 'Placeholder content for default image');
            }
        }

        Author::factory(100)->create()->each(function ($author) use ($storedDefaultCoverPath) {
            $publisher = Publisher::factory()->create();

            Book::factory(10)->make([
                'category_id' => Category::inRandomOrder()->first()->id,
                'publisher_id' => $publisher->id,
                'cover_image' => fn () => rand(0, 1) ? $storedDefaultCoverPath : null,
            ])->toArray()
            ->each(function ($bookAttributes) use ($author) {
                $author->books()->create($bookAttributes);
            });
        });
    }
}
