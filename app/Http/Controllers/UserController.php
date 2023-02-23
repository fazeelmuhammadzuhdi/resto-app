<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.user.index');
    }


    public function fetchUser(Request $request)
    {
        $user = User::all();

        if ($request->ajax()) {
            return datatables()->of($user)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '
                        <div class="btn-group">
                            <button id="btnEditUser" class="btn btn-warning btn-sm" data-id="' . $row['id'] . '">
                                <span class="fas fa-edit"></span> Edit
                            </button>
                            <button id="btnDeleteUser" class="btn btn-danger btn-sm mx-2" data-id="' . $row['id'] . '">
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
            'email' => 'email|required|unique:users,email',
            'roles' => 'required',
            'password' => 'required|string',
        ], [
            'name.required' => 'Field Nama Wajib Diisi',
            'email.email' => 'Field Email Harus Valid Contoh : fazeel@gmail.com',
            'email.required' => 'Field Email Wajib Diisi',
            'email.unique' => 'Email Sudah Ada',
            'roles.required' => 'Field Roles Wajib Diisi',
            'password.required' => 'Field Password Wajib Diisi',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'status' => 400,
                'error' => $validation->errors()->toArray(),
            ]);
        } else {
            $dataUser = new User();
            $dataUser->name = $request->name;
            $dataUser->email = $request->email;
            $dataUser->roles = $request->roles;
            $dataUser->password = bcrypt($request->password);
            $dataUser->save();

            return response()->json([
                'status' => 200,
                'success' => "Data User Berhasil Di Simpan"
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $user = User::findOrFail($request->idUser);
        // $user = User::findOrFail($request->get('idUser'));

        return response()->json([
            'status' => 200,
            'user' => $user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'email|required',
            'roles' => 'required',
            'password' => 'nullable',
        ], [
            'name.required' => 'Field Nama Wajib Diisi',
            'email.email' => 'Field Email Harus Valid Contoh : fazeel@gmail.com',
            'email.required' => 'Field Email Wajib Diisi',
            'roles.required' => 'Field Roles Wajib Diisi',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'status' => 400,
                'error' => $validation->errors()->toArray(),
            ]);
        } else {
            $dataUser = User::findOrFail($request->idUser);
            $dataUser->name = $request->name;
            $dataUser->email = $request->email;
            $dataUser->roles = $request->roles;

            if ($dataUser->password && $request->password == "") {
                unset($request->password);
            } else {
                $dataUser->password = bcrypt($request->password);
            }
            $dataUser->update();

            return response()->json([
                'status' => 200,
                'success' => "Data User Dengan Nama " . $dataUser->name . " Berhasil Di Update"
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $dataUser = User::findOrFail($request->idUser);

        if ($dataUser->id == auth()->user()->id) {
            return response()->json([
                'status' => 400,
                'error' => "Tidak Bisa Hapus Data, Karena User Sedang Aktif"
            ]);
        }
        $dataUser->delete();

        return response()->json([
            'status' => 200,
            'success' => "Data Dengan Nama " . $dataUser->name . " Berhasil Di Hapus"
        ]);
    }

    public function destroySelected(Request $request)
    {
        $idUser = $request->idUsers;
        $query = User::whereIn('id', $idUser)->delete();

        if ($query) {
            return response()->json([
                'status' => 200,
                'success' => "Data User Berhasil Di Hapus"
            ]);
        }
    }
}
