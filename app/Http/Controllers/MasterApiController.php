<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;

class MasterApiController extends BaseController
{
   
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function index()
    {
        $data = $this->model->all();
        return response()->json($data);
    }



    public function store(Request $request)
    {
        $this->validate($request, $this->cliente->rules());

        $dataForm = $request->all();

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $extension = $request->image->extension();

            $name = uniqid(date('His'));
            $nameFile = "{$name}.{$extension}";
            $upload = Image::make($dataForm['image'])->resize(177, 236)->save(storage_path("app/public/clientes/$nameFile", 70));

            if (!$upload) {
                return response()->json(['error' => 'falha ao fazer upload'], 500);
            } else {
                $dataForm['image'] = $nameFile;
            }
        }

        $data = $this->cliente->create($dataForm);

        return response()->json($data, 201);
    }


    public function show($id)
    {
        if (!$data = $this->cliente->find($id)) {
            return response()->json(['error' => 'Nada foi encontrado'], 404);
        } else {
            return response()->json($data);
        }
    }


    public function update(Request $request, $id)
    {
        if (!$data = $this->cliente->find($id))
            return response()->json(['error' => 'Nada foi encontrado'], 404);

        $this->validate($request, $this->cliente->rules());

        $dataForm = $request->all();

        if ($request->hasFile('image') && $request->file('image')->isValid()) {

            if ($data->image) {
                Storage::disk('public')->delete("/clientes/$data->image");
            }

            $extension = $request->image->extension();

            $name = uniqid(date('His'));
            $nameFile = "{$name}.{$extension}";
            $upload = Image::make($dataForm['image'])->resize(177, 236)->save(storage_path("app/public/clientes/$nameFile", 70));

            if (!$upload) {
                return response()->json(['error' => 'falha ao fazer upload'], 500);
            } else {
                $dataForm['image'] = $nameFile;
            }
        }

        $data->update($dataForm);

        return response()->json($data);
    }


    public function destroy($id)
    {

        if (!$data = $this->cliente->find($id))
            return response()->json(['error' => 'Nada foi encontrado'], 404);
        if ($data->image) {
            Storage::disk('public')->delete("/clientes/$data->image");
        }
        $data->delete();
        return response()->json(['sucess' => 'Deletado com sucesso']);
    }
}