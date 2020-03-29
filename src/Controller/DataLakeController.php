<?php

namespace App\Controller;

use App\Entity\Bot;
use App\Entity\DataLake;
use App\Repository\DataLakeRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class DataLakeController extends AbstractController
{
    /**
     * @Route("/datalake/{bot_id}", name="data_lake", methods={"GET"})
     * @ParamConverter("bot", options={"id" = "bot_id"})
     * @param Bot $bot
     * @param DataLakeRepository $repository
     * @return JsonResponse
     */
    public function list(Bot $bot, DataLakeRepository $repository): JsonResponse
    {
        return $this->json(array_map(function (DataLake $dataLake) {
            return $dataLake->toArray();
        }, $repository->findBy(['bot_id' => $bot->getId()], ['id' => 'DESC'])));
    }
}
