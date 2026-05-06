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
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ],
            [
                'geometry_point.required' => 'Field geometry point harus diisi',
                'name.required' => 'Field name harus diisi',
                'name.string' => 'Field name harus berupa string',
                'name.max' => 'Field name tidak boleh lebih dari 255 karakter',
                'description.required' => 'Field description harus diisi',
                'description.string' => 'Field description harus berupa string',
                'image.image' => 'File harus berupa file gambar',
                'image.mimes' => 'File gambar harus berformat jpeg, png, atau jpg.',
                'image.max'=> 'Ukuran file gambar tidak boleh lebih dari 2048 KB.'
            ]
        );

        //create direktori for image if it doesn't exist
        if (!is_dir('storage/images')) {
            mkdir('./storage/images', 0777);
        }

        //get the upload image
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name_image = time() . "_point." . strtolower($image->getClientOriginalExtension());

            $image->move(public_path('storage/images'), $name_image);
        } else {
            $name_image = null;
        }

        $data = [
            'geom' => $request->geometry_point,
            'name' => $request->name,
            'description' => $request->description,
            'image' => $name_image,
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
        //mencari file gambar berdasarkan ID Point
        $image = $this->points->find($id)->image;

        //hapus data ke database
        if (!$this->points->destroy($id)) {
            return redirect()->Route('peta')->with('error','Gagal menghapus data
            point.');
        }

        //Hapus file gambar jika ada
        if ($image && file_exists('./storage/images/' . $image)) {
            unlink('./storage/images/' . $image);
        }

        // kembali ke halaman peta
        return redirect()->Route('peta')->with('success','Data point berhasil
        dihapus.');
        }
    }
