<?php
declare(strict_types=1);

namespace App\Http\Actions\AddPoint;

use Acme\Point\Core\UseCases\AddPoint\AddPointUseCase;
use Illuminate\Http\JsonResponse;

class AddPointAction
{
    /** @var AddPointUseCase */
    private $useCase;
    /**
     * @var \Illuminate\Contracts\Routing\ResponseFactory
     */
    private $responseFactory;

    /**
     * @param AddPointUseCase $useCase
     */
    public function __construct(AddPointUseCase $useCase, \Illuminate\Contracts\Routing\ResponseFactory $responseFactory)
    {
        $this->useCase = $useCase;
        $this->responseFactory = $responseFactory;
    }

    /**
     * @param AddPointRequest $request
     * @return JsonResponse
     * @throws \Throwable
     */
    public function __invoke(AddPointRequest $request): JsonResponse
    {
        $customerId = filter_var($request->json('customer_id'), FILTER_VALIDATE_INT);
        $addPoint = filter_var($request->json('add_point'), FILTER_VALIDATE_INT);

        $customerPoint = $this->useCase->run($customerId, $addPoint);

        return $this->responseFactory->json(['customer_point' => $customerPoint]);
    }
}
