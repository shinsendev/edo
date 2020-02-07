<?php


namespace App\Component\Configuration;


class NarrativeConfiguration
{
    const MAX_VERSIONNING_FRAGMENTS = 100;

    public static function getMaxVersionningFragments()
    {
        // we display the conf only if the value is not set manually in env
        if(isset($_ENV['VERSIONING_MAX'])) {
           return $_ENV['VERSIONING_MAX'];
        }

        $conf = ConfigurationParser::parse('narrative');
        $max = $conf['versionning']['maxFragmentsByNarrative'];

        return $max;
    }
}