<?php

declare(strict_types=1);


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class NotFoundController
 * @package App\Controller
 */
class NotFoundController extends AbstractController
{
    public function __invoke()
    {
        throw new NotFoundHttpException('Not Found');
    }
}