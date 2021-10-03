<?php

namespace Database\Seeders;

use App\Models\News;
use Exception;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        DB::table('news')->delete();
        News::factory(random_int(15, 25))->create();
    }
}
