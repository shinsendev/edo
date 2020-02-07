<?php

namespace App\Controller;

use App\Component\Configuration\ConfigurationParser;
use App\Component\Configuration\NarrativeConfiguration;
use Shivas\VersioningBundle\Service\VersionManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Yaml\Yaml;

class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="default")
     */
    public function index(VersionManager $manager)
    {
        $version = $manager->getVersion();
        $payload = $version;

        return new JsonResponse($payload);
    }

    /**
     * @Route("/test", name="test")
     */
    public function test()
    {
        $value = NarrativeConfiguration::getMaxVersionningFragments();
        dd($value);

    }
}
