<?php
/**
 * Laravel IDE Helper Generator
 *
 * @author    Barry vd. Heuvel <barryvdh@gmail.com>
 * @copyright 2014 Barry vd. Heuvel / Fruitcake Studio (http://www.fruitcakestudio.nl)
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 * @link      https://github.com/barryvdh/laravel-ide-helper
 */

namespace Xversial\LaravelCdnHelper;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\Engines\PhpEngine;
use Illuminate\View\Factory;
use Illuminate\View\FileViewFinder;

class CdnHelperServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->boot_publishes();
        $this->blade_directives();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $configPath = __DIR__ . '/../config/cdn-helper.php';
        $this->mergeConfigFrom( $configPath, 'cdn-helper' );
    }

    private function boot_publishes()
    {
        $configPath = __DIR__ . '/../config/cdn-helper.php';
        if ( function_exists( 'config_path' ) ) {
            $publishPath = config_path( 'cdn-helper.php' );
        } else {
            $publishPath = base_path( 'config/cdn-helper.php' );
        }
        $this->publishes( [ $configPath => $publishPath ], 'config' );
    }

    private function blade_directives()
    {
        Blade::directive( 'cdn', function ( $resourceURI ) {

            $cdnURI = new CdnUri($this->app['config'], $resourceURI);
            return $cdnURI->buildStaticURI();

//            $cdnURL = Config::get( 'app.cdn.url' );
//            $useCDN = ( $cdnURL === null ? false : true );
//            $basePath = ( $useCDN ?
//                $cdnURL :
//                null
//            );

/*            return "<?php echo ($path)->format('m/d/Y H:i'); ?>";*/
        } );
    }
}
