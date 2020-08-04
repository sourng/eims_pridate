<?php

namespace Tests\Browser;

use Tests\DuskTestCase;
use Laravel\Dusk\Browser;
use App\Helpers\Translator;
use App\Helpers\ImageHelper;
use App\Helpers\VideoHelper;
use Illuminate\Support\Facades\Storage;
use dawood\PhpScreenRecorder\ScreenRecorder;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ExampleTest extends DuskTestCase
{
    /**
     * A basic browser test example.
     *
     * @return void
     */
    public function testBasicExample()
    {
        $folder = 'public/'.ImageHelper::$path['image'] . '/screenshot';
        Storage::makeDirectory($folder);
        $destinationPath = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix() . $folder;

        $this->browse(function (Browser $browser) use ($destinationPath) {
            $browser->visit('/')
                ->clickLink(Translator::phrase('login'))
                ->assertSee(Translator::phrase('login'))
                ->value('[name="email"]', 'keamsan.sem@gmail.com')
                ->value('[name="password"]', '123456')
                ->click('[for="remember"]')
                ->click('button[type="submit"]')
                ->driver->takeScreenshot($destinationPath.'/'.ImageHelper::num_random().'.png');
        });

    }
}
