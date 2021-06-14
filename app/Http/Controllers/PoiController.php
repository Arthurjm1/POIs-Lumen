<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\PoiRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PoiController extends Controller
{
    private $repository;

    public function __construct(PoiRepository $repository)
    {
        $this->repository = $repository;
    }

    public function postPoi(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'x' => 'required|numeric',
            'y' => 'required|numeric'
        ]);

        $fields = $request->only(['name', 'x', 'y']);
        $result = $this->repository->insertPoi($fields);
        return response()->json($result);
    }

    public function getPois()
    {
        $result = $this->repository->listPois();
        return response()->json($result);
    }

    public function getPoi(int $id)
    {
        try {
            $result = $this->repository->listPoi($id);
            return response()->json($result);
        } catch (ModelNotFoundException $exception) {
            return response()->json([
                'status' => $exception->getCode(),
                'message' => $exception->getMessage()
            ], 404);
        }
    }

    public function findPois(Request $request)
    {
        $this->validate($request, [
            'x' => 'required|numeric',
            'y' => 'required|numeric',
            'dmax' => 'required|numeric'
        ]);

        $fields = $request->only(['x', 'y', 'dmax']);
        $result = $this->repository->findPois($fields);
        return response()->json($result);
    }
}
