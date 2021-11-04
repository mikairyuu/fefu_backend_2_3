<?php

namespace App\Console\Commands;

use App\Models\News;
use App\Models\Redirect;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Command\Command as CommandAlias;

class ChangeNewsSlug extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'change_news_slug {oldSlug} {newSlug}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $oldSlug = $this->argument('oldSlug');
        $newSlug = $this->argument('newSlug');

        if ($oldSlug === $newSlug) {
            $this->error('Slugs are identical');
            return CommandAlias::FAILURE;
        }
        if (Redirect::where('old_slug', route('news_item', ['slug' => $oldSlug], false))
            ->where('new_slug', route('news_item', ['slug' => $newSlug], false))->exists()) {
            $this->error('Such redirect is already present in the DB');
            return CommandAlias::FAILURE;
        }
        $news = News::where('slug', $oldSlug)->first();
        if ($news === null) {
            $this->error('No page with such slug found');
            return CommandAlias::FAILURE;
        }

        DB::transaction(function () use ($news, $newSlug) {
            Redirect::where('old_slug', route('news_item', ['slug' => $newSlug], false))->delete();

            $news->slug = $newSlug;
            $news->save();
        });

        return CommandAlias::SUCCESS;
    }
}
