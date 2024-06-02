<?php

declare(strict_types=1);

namespace App\Controllers\People;

use App\Repositories\PersonRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use App\Controllers\AbstractController;
use App\Services\SerializeService;

class ListController extends AbstractController
{
    public function __construct(
        protected readonly SerializeService $service,
        protected readonly PersonRepository $repository,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $filter = $request->getQueryParams();

        $res = empty($filter)
            ? $this->repository->findAll()
            : $this->repository->findBy($filter['search']);

        return new Response(
            $res['code'],
            ['content-type' => 'application/json'],
            json_encode($res['data'])
        );
    }
}
