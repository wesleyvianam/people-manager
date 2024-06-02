<?php

declare(strict_types=1);

namespace App\Controllers\People;

use App\Repositories\PersonRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use App\Controllers\AbstractController;
use App\Services\SerializeService;

class RegisterController extends AbstractController
{
    public function __construct(
        protected readonly SerializeService $service,
        protected readonly PersonRepository $repository,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $resData = $this->service->hydrateData($request, ['name','cpf','contact','type']);

        $res = [];
        if (is_array($resData)) {
            $res = $this->repository->register($resData);
        }

        return new Response(
            $res['code'],
            ['content-type' => 'application/json'],
            json_encode($res['data'])
        );
    }
}