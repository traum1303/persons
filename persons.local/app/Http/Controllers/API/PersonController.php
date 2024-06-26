<?php
declare(strict_types=1);

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImportRequest;
use App\Http\Requests\IndexPeopleRequest;
use App\Http\Resources\PersonImportResource;
use App\Http\Resources\PersonsCollection;
use App\Services\Import\ImportService;
use App\Services\PersonService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class PersonController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index(IndexPeopleRequest $request, PersonService $personService): JsonResponse
    {
        $validated = $request->validated();
        $resource = $personService->index($validated);

        return (new PersonsCollection($resource))
            ->response()
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @throws \Exception
     */
    public function import(ImportRequest $request, ImportService $importService): JsonResponse
    {
        $file = $request->validated();

        try {
            $importService->import($file['file']);
        }catch (\Exception $exception){
            return (new PersonImportResource([
                'message' => $exception->getMessage(),
                'success' => false,
            ]))->response()->setStatusCode(Response::HTTP_OK);
        }

        return (new PersonImportResource([
            'message' => __('Your CSV is on its way to being processed!'),
            'success' => true
        ]))->response()->setStatusCode(Response::HTTP_ACCEPTED);
    }
}
