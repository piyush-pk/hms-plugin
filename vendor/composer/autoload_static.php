<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit3d1a58165c1cc1e77ec16199580894dd
{
    public static $prefixLengthsPsr4 = array (
        'H' => 
        array (
            'HMS\\Templates\\' => 14,
            'HMS\\Includes\\Models\\' => 20,
            'HMS\\Includes\\Init\\' => 18,
            'HMS\\Includes\\' => 13,
            'HMS\\Admin\\' => 10,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'HMS\\Templates\\' => 
        array (
            0 => __DIR__ . '/../..' . '/templates',
        ),
        'HMS\\Includes\\Models\\' => 
        array (
            0 => __DIR__ . '/../..' . '/includes/models',
        ),
        'HMS\\Includes\\Init\\' => 
        array (
            0 => __DIR__ . '/../..' . '/includes/init',
        ),
        'HMS\\Includes\\' => 
        array (
            0 => __DIR__ . '/../..' . '/includes',
        ),
        'HMS\\Admin\\' => 
        array (
            0 => __DIR__ . '/../..' . '/admin',
        ),
    );

    public static $classMap = array (
        'Composer\\InstalledVersions' => __DIR__ . '/..' . '/composer/InstalledVersions.php',
        'HMS\\Includes\\Init\\Activate' => __DIR__ . '/../..' . '/includes/init/Activate.php',
        'HMS\\Includes\\Init\\Constants' => __DIR__ . '/../..' . '/includes/init/Constants.php',
        'HMS\\Includes\\Init\\Deactivate' => __DIR__ . '/../..' . '/includes/init/Deactivate.php',
        'HMS\\Includes\\Init\\Pages' => __DIR__ . '/../..' . '/includes/init/Pages.php',
        'HMS\\Includes\\Init\\RegisterMenuPages' => __DIR__ . '/../..' . '/includes/init/RegisterMenuPages.php',
        'HMS\\Includes\\Init\\SettingsLinks' => __DIR__ . '/../..' . '/includes/init/SettingsLinks.php',
        'HMS\\Includes\\Initialize' => __DIR__ . '/../..' . '/includes/Initialize.php',
        'HMS\\Includes\\Models\\Doctor' => __DIR__ . '/../..' . '/includes/models/Doctor.php',
        'HMS\\Includes\\Models\\Patient' => __DIR__ . '/../..' . '/includes/models/Patient.php',
        'HMS\\Templates\\Footer' => __DIR__ . '/../..' . '/templates/Footer.php',
        'HMS\\Templates\\Header' => __DIR__ . '/../..' . '/templates/Header.php',
        'HMS\\Templates\\Layout' => __DIR__ . '/../..' . '/templates/Layout.php',
        'HMS\\Templates\\Tailwind' => __DIR__ . '/../..' . '/templates/Tailwind.php',
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit3d1a58165c1cc1e77ec16199580894dd::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit3d1a58165c1cc1e77ec16199580894dd::$prefixDirsPsr4;
            $loader->classMap = ComposerStaticInit3d1a58165c1cc1e77ec16199580894dd::$classMap;

        }, null, ClassLoader::class);
    }
}
