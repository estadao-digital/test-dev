<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInitf938a720c103f91b4ec275e041f2abe0
{
    public static $prefixLengthsPsr4 = array (
        'R' => 
        array (
            'Routes\\' => 7,
        ),
        'C' => 
        array (
            'Core\\' => 5,
        ),
        'A' => 
        array (
            'App\\' => 4,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Routes\\' => 
        array (
            0 => __DIR__ . '/../..' . '/routes',
        ),
        'Core\\' => 
        array (
            0 => __DIR__ . '/../..' . '/inc',
        ),
        'App\\' => 
        array (
            0 => __DIR__ . '/../..' . '/app',
        ),
    );

    public static $classMap = array (
        'App\\Controllers\\BrandsController' => __DIR__ . '/../..' . '/app/Controllers/BrandsController.php',
        'App\\Controllers\\CarsController' => __DIR__ . '/../..' . '/app/Controllers/CarsController.php',
        'App\\Models\\BrandsModel' => __DIR__ . '/../..' . '/app/Models/BrandsModel.php',
        'App\\Models\\CarsModel' => __DIR__ . '/../..' . '/app/Models/CarsModel.php',
        'App\\Tests\\Tests' => __DIR__ . '/../..' . '/app/Tests/Tests.php',
        'App\\Tests\\Units\\CarsControllerTest' => __DIR__ . '/../..' . '/app/Tests/Units/CarsControllerTest.php',
        'App\\Validators\\Validator' => __DIR__ . '/../..' . '/app/Validators/Validator.php',
        'App\\Views\\Template\\Body' => __DIR__ . '/../..' . '/app/Views/Template/Body.php',
        'App\\Views\\Template\\Scripts' => __DIR__ . '/../..' . '/app/Views/Template/Scripts.php',
        'App\\Views\\Template\\Styles' => __DIR__ . '/../..' . '/app/Views/Template/Styles.php',
        'App\\Views\\Template\\Template' => __DIR__ . '/../..' . '/app/Views/Template/Template.php',
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'Core\\JsonDb' => __DIR__ . '/../..' . '/inc/JsonDb.php',
        'Core\\Output' => __DIR__ . '/../..' . '/inc/Output.php',
        'Core\\Requests' => __DIR__ . '/../..' . '/inc/Requests.php',
        'Core\\Router' => __DIR__ . '/../..' . '/inc/Router.php',
        'Core\\Utilities' => __DIR__ . '/../..' . '/inc/Utilities.php',
        'Routes\\Routes' => __DIR__ . '/../..' . '/routes/Routes.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInitf938a720c103f91b4ec275e041f2abe0::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInitf938a720c103f91b4ec275e041f2abe0::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInitf938a720c103f91b4ec275e041f2abe0::$classMap;

        }, null, ClassLoader::class);
    }
}
