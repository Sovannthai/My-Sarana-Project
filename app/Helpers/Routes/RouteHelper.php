<?php

namespace App\Helpers\Routes;

class RouteHelper
{
    public static function includeRouteFiles(string $folder)
    {
        $dirIterator = new \RecursiveDirectoryIterator($folder);
        $it = new \RecursiveIteratorIterator($dirIterator);

        $phpFils = [];

        foreach ($it as $fileInfo)
        {
            if (!$fileInfo->isDir() && $fileInfo->isfile() && $fileInfo->isReadable() && $fileInfo->getExtension() === 'php')
            {
                $phpFils[] = $fileInfo->getPathname();
            }
        }

        foreach ($phpFils as $file)
        {
            require $file;
        }
    }
}
