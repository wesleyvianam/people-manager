<?php

declare(strict_types=1);

namespace App\Controllers\Contact;

use App\Repositories\ContactRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use App\Controllers\AbstractController;
use App\Services\SerializeService;

class RegisterController extends AbstractController
{
    public function __construct(
        protected readonly SerializeService $service,
        protected readonly ContactRepository $repository,
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $resData = $this->service->hydrateData($request, ['contact','type', 'person_id']);
        $person = [];
        if (is_array($resData)) {
            $person = $this->repository->register($resData);
        }

        return new Response(200, ['content-type' => 'application/json'], json_encode($person));
    }
}