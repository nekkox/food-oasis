<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class OtherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //about page
        $abouts = [
            [
                'id' => 1,
                'image' => 'uploads/media_66a93ce63071e.jpg',
                'title' => 'About Company',
                'main_title' => 'Helathy Foods Provider',
                'description' => "<div class=\"fp__about_us_text\">\r\n                    <p> Lorem, ipsum dolor sit amet consectetur \r\nadipisicing elit. Cupiditate aspernatur molestiae minima pariatur \r\nconsequatur voluptate sapiente deleniti soluta, animi ab necessitatibus \r\noptio similique quasi fuga impedit corrupti obcaecati neque consequatur \r\nsequi\r\n\r\n    Delicious &amp; Healthy Foods\r\n    Spacific Family &amp; Kids Zone\r\n    Best Price &amp; Offers\r\n    Made By Fresh Ingredients\r\n    Music &amp; Other Facilities\r\n    Delicious &amp; Healthy Foods\r\n    Spacific Family &amp; Kids Zone\r\n    Best Price &amp; Offers\r\n    Made By Fresh Ingredients\r\n    Delicious &amp; Healthy Foods</p>\r\n                    <ul><li>Delicious &amp; Healthy Foods </li><li>Spacific Family &amp; Kids Zone</li><li>Best Price &amp; Offers</li><li>Made By Fresh Ingredients</li><li>Music &amp; Other Facilities</li><li>Delicious &amp; Healthy Foods </li><li>Spacific Family &amp; Kids Zone</li><li>Best Price &amp; Offers</li><li>Made By Fresh Ingredients</li><li>Delicious &amp; Healthy Foods </li></ul>\r\n                </div>",
                'video_link' => 'https://www.youtube.com/watch?v=-j0vFDgiH4I',
                'created_at' => '2024-07-30 18:01:21',
                'updated_at' => '2024-07-30 21:30:51',
            ],
        ];

        DB::table('abouts')->insert($abouts);


        $app_download_sections = [
            [
                'id' => 1,
                'image' => 'uploads/media_66a65f4c64393.png',
                'background' => 'uploads/media_66a65f4c6480d.jpg',
                'title' => 'download our mobile apps',
                'short_description' => 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Cumque assumenda tenetur, provident earum consequatur, ut voluptas laboriosam fuga error aut eaque architecto quo pariatur. Vel dolore omnis quisquam. Lorem ipsum dolor, sit amet consectetur adipisicing elit Cumque.',
                'play_store_link' => null,
                'apple_store_link' => null,
                'created_at' => '2024-07-28 15:08:25',
                'updated_at' => '2024-07-28 15:10:04',
            ],
        ];

        DB::table('app_download_sections')->insert($app_download_sections);
    }


    
}
