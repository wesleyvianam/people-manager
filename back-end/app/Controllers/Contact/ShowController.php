<?php

declare(strict_types=1);

namespace App\Controllers\Contact;

use App\Repositories\ContactRepository;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use App\Controllers\AbstractController;
use App\Services\SerializeService;

class ShowController extends AbstractController
{
    public function __construct(
        protected readonly SerializeService $service,
        protected readonly ContactRepository $repository
    ) {
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $contactId = $this->getUserId($request->getServerParams()['REQUEST_URI']);

        $res = $this->repository->findById($contactId);

        return new Response(200, ['content-type' => 'application/json'], json_encode($res));
    }
}
