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
                'geometry_polygon' => 'required',
                'name' => 'required',
                'description' => 'required',
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ],
            [
                'geometry_polygon.required' => 'Field geometry polygon harus diisi',
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
            $name_image = time() . "_polygon." . strtolower($image->getClientOriginalExtension());

            $image->move(public_path('storage/images'), $name_image);
        } else {
            $name_image = null;
        }

        $data = [
            'geom' => $request->geometry_polygon,
            'name' => $request->name,
            'description' => $request->description,
            'image' => $name_image,
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

