<?php

namespace App\Http\Controllers;

use App\Models\pointsModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PointsController extends Controller
{
    protected $points;
    public function __construct()
    {
        $this->points = new pointsModel();
    }

    public function geojson()
    {
    $points = $this->points->all();

    $features = [];

    foreach ($points as $point) {

        // convert WKT -> GeoJSON
        $geom = DB::select("SELECT ST_AsGeoJSON('$point->geom') as geojson");

        $features[] = [
            "type" => "Feature",
            "geometry" => json_decode($geom[0]->geojson),
            "properties" => [
                "name" => $point->name,
                "description" => $point->description,
                "created_at" => $point->created_at
            ]
        ];
    }

    return response()->json([
        "type" => "FeatureCollection",
        "features" => $features
    ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         //validation
        $request->validate(
            [
                'geometry_point' => 'required',
                'name' => 'required',
                'description' => 'required',
            ],
            [
                'geometry_point.required' => 'Field geometry point harus diisi',
                'name.required' => 'Field name harus diisi',
                'name.string' => 'Field name harus berupa string',
                'name.max' => 'Field name tidak boleh lebih dari 255 karakter',
                'description.required' => 'Field description harus diisi',
                'description.string' => 'Field description harus berupa string',
            ]
        );

        $data = [
            'geom' => $request->geometry_point,
            'name' => $request->name,
            'description' => $request->description,
        ];

        //simpan data ke database
        if (!$this->points->create($data)) {
            return redirect()->Route('peta')->with('error','Gagal menyimpan data
            point.');
        }

        // kembali ke halaman peta
        return redirect()->Route('peta')->with('success','Data point berhasil
        disimpan.');
        }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
