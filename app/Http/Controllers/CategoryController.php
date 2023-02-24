<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.kategori.index');
    }

    public function fetchCategory(Request $request)
    {
        $category = Category::all();

        if ($request->ajax()) {
            return datatables()->of($category)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '
                        <div class="btn-group">
                            <button id="btnEditKategori" class="btn btn-warning btn-sm" data-id="' . $row['id'] . '">
                                <span class="fas fa-edit"></span> Edit
                            </button>
                            <button id="btnDeleteKategori" class="btn btn-danger btn-sm mx-2" data-id="' . $row['id'] . '">
                                <span class="fas fa-trash-alt"></span> Hapus
                            </button>
                        </div>
                    ';
                })
                ->addColumn('checkbox', function ($row) {
                    return '
                         <input data-id="' . $row['id'] . '" type="checkbox" name="user_checkbox" id="user_checkbox">
                         <label for=""></label>
                    ';
                })
                ->rawColumns(['action', 'checkbox'])
                ->make(true);
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string',
        ], [
            'name.required' => 'Field Nama Wajib Diisi',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'status' => 400,
                'error' => $validation->errors()->toArray(),
            ]);
        } else {
            $dataKategori = new Category();
            $dataKategori->name = $request->name;
            $dataKategori->slug = Str::slug($request->name);
            $dataKategori->save();

            return response()->json([
                'status' => 200,
                'success' => "Data Kategori Berhasil Di Simpan"
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $category = Category::findOrFail($request->idKategori);
        // $user = User::findOrFail($request->get('idUser'));

        return response()->json([
            'status' => 200,
            'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string',

        ], [
            'name.required' => 'Field Nama Wajib Diisi',

        ]);

        if ($validation->fails()) {
            return response()->json([
                'status' => 400,
                'error' => $validation->errors()->toArray(),
            ]);
        } else {
            $dataKategori = Category::findOrFail($request->idKategori);
            $dataKategori->name = $request->name;
            $dataKategori->slug = Str::slug($request->name);
            $dataKategori->update();

            return response()->json([
                'status' => 200,
                'success' => "Data Kategori Dengan Nama " . $dataKategori->name . " Berhasil Di Update"
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $dataKategori = Category::findOrFail($request->idKategori);
        $dataKategori->delete();

        return response()->json([
            'status' => 200,
            'success' => "Data Dengan Nama Kategori " . $dataKategori->name . " Berhasil Di Hapus"
        ]);
    }

    public function destroySelected(Request $request)
    {
        $idKategori = $request->idKategoris;
        $query = Category::whereIn('id', $idKategori)->delete();

        if ($query) {
            return response()->json([
                'status' => 200,
                'success' => "Data User Berhasil Di Hapus"
            ]);
        }
    }
}
