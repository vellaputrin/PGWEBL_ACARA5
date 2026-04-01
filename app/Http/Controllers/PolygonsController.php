<?php

namespace App\Http\Controllers;

use App\Models\polygonsModel;
use Illuminate\Http\Request;

class PolygonsController extends Controller
{
    protected $polygons;
    public function __construct()
    {
        $this->polygons = new polygonsModel();
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'geometry_polygons' => 'required',
                'name' => 'required',
                'description' => 'required',
            ],
            [
                'geometry_polygon.required' => 'Field geometry polygon harus diisi',
                'name.required' => 'Field name harus diisi',
                'name.string' => 'Field name harus berupa string',
                'name.max' => 'Field name tidak boleh lebih dari 255 karakter',
                'description.required' => 'Field description harus diisi',
                'description.string' => 'Field description harus berupa string',
            ]
        );

        $data = [
            'geom' => $request->geometry_polygons,
            'name' => $request->name,
            'description' => $request->description,
        ];

        //simpan data ke database
        if (!$this->polygons->create($data)) {
            return redirect()->Route('peta')->with('error','Gagal menyimpan data
            polygons.');
        }

        // kembali ke halaman peta
        return redirect()->Route('peta')->with('success','Data polygon berhasil
        disimpan.');
        }

}

