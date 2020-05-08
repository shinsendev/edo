<?php


namespace App\Component\Configuration;


use App\Component\Error\EdoError;

class FragmentConfiguration
{
    public static function getMaxVersionning()
    {
        // we display the conf only if the value is not set manually in env
        if(isset($_ENV['VERSIONING_MAX'])) {
           return $_ENV['VERSIONING_MAX'];
        }

        try {
            $conf = ConfigurationParser::parse('fragment');
            $max = $conf['versioning']['max'];
        }
        catch (\Error $e) {
            throw new EdoError('No max versioning limit in configuration for fragment');
        }

        return $max;
    }
}