<?php

namespace Toyza55k\Backend;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Laravel\Ui\Presets\Preset as LaravelPreset;

class Preset extends LaravelPreset
{
    public static function install()
    {
        static::cleanSassDirectory();
        static::updateSass();
        static::updatePackages();
        static::updateMix();
        static::updateScripts();
    }

    protected static function updatePackageArray(array $packages)
    {
        return [
            'bootstrap' => '^4.0.0',
            'jquery' => '^3.2',
            'popper.js' => '^1.12',
            "@fortawesome/fontawesome-free" => "^5.12.1",
            "@ttskch/select2-bootstrap4-theme" => "^1.3.2",
            "admin-lte" => "^3.0.2",
            "inputmask" => "^5.0.3",
            "jquery-validation" => "^1.19.1",
            "ladda" => "^2.0.1",
            "moment" => "^2.24.0",
            "toastr" => "^2.1.4"
        ] + Arr::except($packages, [
            '@babel/preset-react',
            'react',
            'react-dom',
            'vue', 
            'vue-template-compiler'
        ]);
    }

    public static function cleanSassDirectory()
    {
    	File::cleanDirectory(resource_path('sass'));
    }

    public static function updateSass()
    {
    	$resourceSassDir = __DIR__.'/stubs/resources/sass';

    	File::ensureDirectoryExists(resource_path('sass/backend'));

    	copy($resourceSassDir.'/_elements.scss', resource_path('sass/_elements.scss'));
    	copy($resourceSassDir.'/_variables.scss', resource_path('sass/_variables.scss'));
    	copy($resourceSassDir.'/app.scss', resource_path('sass/app.scss'));
    	copy($resourceSassDir.'/toastr.scss', resource_path('sass/toastr.scss'));
    	copy($resourceSassDir.'/backend/_elements.scss', resource_path('sass/backend/_elements.scss'));
    	copy($resourceSassDir.'/backend/_variables.scss', resource_path('sass/backend/_variables.scss'));
    	copy($resourceSassDir.'/backend/app.scss', resource_path('sass/backend/app.scss'));
    }

    public static function updateMix()
    {
    	copy(__DIR__.'/stubs/webpack.mix.js', base_path('webpack.mix.js'));
    }

    public static function updateScripts()
    {
    	$resourceJsDir = __DIR__.'/stubs/resources/js';

    	File::ensureDirectoryExists(resource_path('js/backend'));
    	File::ensureDirectoryExists(resource_path('js/module'));

    	copy($resourceJsDir.'/app.js', resource_path('js/app.js'));
    	copy($resourceJsDir.'/bootstrap.js', resource_path('js/bootstrap.js'));
    	copy($resourceJsDir.'/module/axios-toastr-noti.js', resource_path('js/module/axios-toastr-noti.js'));
    	copy($resourceJsDir.'/backend/app.js', resource_path('js/backend/app.js'));
    	copy($resourceJsDir.'/backend/bootstrap.js', resource_path('js/backend/bootstrap.js'));
    	copy($resourceJsDir.'/backend/my-dt-func.js', resource_path('js/backend/my-dt-func.js'));
    }
}