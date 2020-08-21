<?php

declare(strict_types=1);

namespace App\Controller;

use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HealthCheckController extends AbstractController
{
    /**
     * @Route("/health/check", name="health_check")
     */
    public function index()
    {
        return $this->json(
            [
                'status' => 'ok',
                'now'    => (new DateTime())->format('Y-m-d H:m:s'),
            ]
        );
    }
}
