<?php

declare(strict_types=1);

namespace App\Controllers\Contact;

use App\Repositories\ContactRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use App\Controllers\AbstractController;
use App\Services\SerializeService;

class ListController extends AbstractController
{
    public function __construct(
        protected readonly SerializeService $service,
        protected readonly ContactRepository $repository,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $filter = $request->getQueryParams();

        $res = !isset($filter['search'])
            ? $this->repository->findAll()
            : $this->repository->findBy($filter['search']);

        return new Response(
            200,
            ['Content-Type' => 'application/json'],
            json_encode($res['data'])
        );
    }
}
