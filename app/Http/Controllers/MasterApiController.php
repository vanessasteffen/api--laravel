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
        $this->validate($request, $this->model->rules());

        $dataForm = $request->all();

        if ($request->hasFile($this->upload) && $request->file($this->upload)->isValid()) {
            $extension = $request->image->extension();

            $name = uniqid(date('His'));
            $nameFile = "{$name}.{$extension}";
            $upload = Image::make($dataForm['image'])->resize($this->widht, $this->height)->save(storage_path("app/public/clientes/$nameFile", 70));

            if (!$upload) {
                return response()->json(['error' => 'falha ao fazer upload'], 500);
            } else {
                $dataForm['image'] = $nameFile;
            }
        }

        $data = $this->model->create($dataForm);

        return response()->json($data, 201);
    }


    public function show($id)
    {
        if (!$data = $this->model->find($id)) {
            return response()->json(['error' => 'Nada foi encontrado'], 404);
        } else {
            return response()->json($data);
        }
    }


    public function update(Request $request, $id)
    {
        if (!$data = $this->model->find($id))
            return response()->json(['error' => 'Nada foi encontrado'], 404);

        $this->validate($request, $this->model->rules());

        $dataForm = $request->all();

        if ($request->hasFile('image') && $request->file('image')->isValid()) {

            if ($data->image) {
                Storage::disk('public')->delete("/clientes/$data->image");
            }

            $extension = $request->image->extension();

            $name = uniqid(date('His'));
            $nameFile = "{$name}.{$extension}";
            $upload = Image::make($dataForm['image'])->resize($this->widht, $this->height)->save(storage_path("app/public/{$this->path}/{$nameFile}", 70));

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

        if ($data = $this->model->find($id)) {
            if (method_exists($this->model, 'arquivo')) {
                Storage::disk('public')->delete("/{$this->path}/{$this->model->arquivo($id)}");
            }
            $data->delete();
            return response()->json(['sucess' => 'Deletado com sucesso']);
        } else {
            return response()->json(['error' => 'Nada foi encontrado'], 404);
        }
    }
}
