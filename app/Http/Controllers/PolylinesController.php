<?php

namespace App\Http\Controllers;

use App\Models\polylinesModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PolylinesController extends Controller
{
    protected $polylines;
    public function __construct()
    {
        $this->polylines = new polylinesModel();
    }

    public function geojson()
    {
    $polylines = $this->polylines->all();

    $features = [];

    foreach ($polylines as $line) {

        $geom = DB::select("SELECT ST_AsGeoJSON('$line->geom') as geojson");

        $features[] = [
            "type" => "Feature",
            "geometry" => json_decode($geom[0]->geojson),
            "properties" => [
                "name" => $line->name,
                "description" => $line->description,
                "created_at" => $line->created_at
            ]
        ];
    }

    return response()->json([
        "type" => "FeatureCollection",
        "features" => $features
    ]);
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'geometry_polyline' => 'required',
                'name' => 'required',
                'description' => 'required',
            ],
            [
                'geometry_polyline.required' => 'Field geometry polyline harus diisi',
                'name.required' => 'Field name harus diisi',
                'name.string' => 'Field name harus berupa string',
                'name.max' => 'Field name tidak boleh lebih dari 255 karakter',
                'description.required' => 'Field description harus diisi',
                'description.string' => 'Field description harus berupa string',
            ]
        );

        $data = [
            'geom' => $request->geometry_polyline,
            'name' => $request->name,
            'description' => $request->description,
        ];

        //simpan data ke database
        if (!$this->polylines->create($data)) {
            return redirect()->Route('peta')->with('error','Gagal menyimpan data
            polylines.');
        }

        // kembali ke halaman peta
        return redirect()->Route('peta')->with('success','Data polyline berhasil
        disimpan.');
        }

}
