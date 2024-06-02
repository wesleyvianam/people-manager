<?php

declare(strict_types=1);

namespace App\Controllers\Contact;

use App\Repositories\ContactRepository;
use App\Services\SerializeService;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use App\Controllers\AbstractController;

class DeleteController extends AbstractController
{
    public function __construct(
        protected readonly SerializeService $service,
        protected readonly ContactRepository $repository
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $userId = $this->getUserId($request->getServerParams()['REQUEST_URI']);

        $res = $this->repository->delete($userId);

        return new Response(
            $res['code'],
            ['Content-Type' => 'application/json'],
            json_encode($res['data'])
        );
    }
}