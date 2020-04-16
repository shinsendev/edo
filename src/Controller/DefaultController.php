<?php

namespace App\Controller;

use App\Component\DTO\Tree\PositionConvertor;
use App\Entity\Position;
use Doctrine\ORM\EntityManagerInterface;
use Shivas\VersioningBundle\Service\VersionManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

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

}
