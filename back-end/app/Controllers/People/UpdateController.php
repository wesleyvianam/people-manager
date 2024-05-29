<?php

declare(strict_types=1);

namespace App\Controllers\People;

use App\Repositories\PersonRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use App\Controllers\AbstractController;
use App\Services\SerializeService;

class UpdateController extends AbstractController
{
    public function __construct(
        protected readonly SerializeService $service,
        protected readonly PersonRepository $repository
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $userId = $this->getUserId($request->getServerParams()['REQUEST_URI']);
        $resData = $this->service->hydrateData($request);

        if (!empty($resData)) {
            $res = $this->repository->update($userId, $resData);
        }

        return new Response(200, ['content-type' => 'application/json'], json_encode($res ?? []));
    }
}