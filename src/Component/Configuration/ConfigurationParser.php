<?php


namespace App\Component\Configuration;


use Symfony\Component\Yaml\Yaml;

/**
 * Class ConfigurationParser
 * @package App\Component\Configuration
 */
class ConfigurationParser
{
    /**
     * @param $configurationName
     * @return mixed
     */
    public static function  parse($configurationName)
    {
        return Yaml::parseFile(__DIR__.'/'.$configurationName.'.yaml');
    }
}