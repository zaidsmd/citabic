<?php

namespace App\Providers;

use App\Helpers\NumberWrapper;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class NumberWrapperServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // Blade directive
        Blade::directive('numbers', function ($expression) {
            return "<?php echo App\Helpers\NumberWrapper::wrapNumbers($expression); ?>";
        });

        // Blade if statement
        Blade::if('hasnumbers', function ($text) {
            return preg_match('/\d/', $text);
        });
    }

    public function register()
    {
        $this->app->singleton('number-wrapper', function () {
            return new NumberWrapper;
        });
    }
}
