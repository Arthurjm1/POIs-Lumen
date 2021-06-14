<?php

namespace App\Repositories;

use App\Models\Poi;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PoiRepository
{
    public function insertPoi(array $fields): array
    {
        $poi = new Poi();
        $poi->name = $fields['name'];
        $poi->x = $fields['x'];
        $poi->y = $fields['y'];
        $poi->save();

        return [
            'id' => $poi->id
        ];
    }

    public function listPois(): Collection
    {
        $pois = Poi::all();
        foreach ($pois as $singlePoi) {
            $singlePoi->links = [(object)[
                'rel' => 'self',
                'href' => "/poi/$singlePoi->id"
            ]];
        }
        return $pois;
    }

    public function listPoi($id): Poi
    {
        $poi = Poi::find($id);
        if (!$poi) {
            throw new ModelNotFoundException("ID doesn't exists", 404);
        }
        return $poi;
    }

    public function findPois(array $fields): array
    {
        $pois = Poi::all();
        $payload = array();

        foreach ($pois as $poi) {
            $dist = sqrt(pow($poi->x - $fields['x'], 2) + pow($poi->y - $fields['y'], 2));
            if ($dist <= $fields['dmax']) {
                $poi->links = [
                    (object)[
                        'rel' => 'self',
                        'href' => "/poi/$poi->id"
                    ]
                ];
                array_push($payload, $poi);
            }
        }

        return $payload;
    }
}
