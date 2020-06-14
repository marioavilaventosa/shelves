<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Categorias;
use App\Productos;

class CategoriasController extends Controller
{

    public function index()
    {
        $categorias = Categorias::all();
        return view('admin.categorias', ['categorias'=>$categorias]);
    }

    public function eliminar($id){
        $categoria = Categorias::findOrFail($id);
        $categorias = Categorias::where('catsuperior','=',$categoria->id)->get();
        $productos = Productos::where('categorias_id','=',$categoria->id)->get();
        if(count($categorias) != 0){
            return redirect()->back()->with('message', 'Existen categorias con esta categoria de nivel superior, eliminelas o modifiquelas');
        }else if(count($productos)){
            return redirect()->back()->with('message', 'Existen productos con esta categoria, eliminelos o modifiquelos');
        }else{
            $categoria->delete();
        }
        return redirect('admin/categorias'); 
    }

    public function formeditar($id){
        $categorias = Categorias::findOrFail($id);
        return view('admin.editarcategoria', ['categorias'=>$categorias]);
    }

    public function editar(Request $request){
        $categorias = Categorias::findOrFail($request->input('id'));
        $categorias->nombre = $request->input('nombre');
        if($request->input('catsuperior')!=0){
            $categoriassuperior = Categorias::findOrFail($request->input('catsuperior'));
            if($categoriassuperior->catsuperior == NULL){
                $categorias->catsuperior = $request->input('catsuperior');
            }else{
                return redirect()->back()->with('message', 'Esa categoria ya tiene un nivel superior');
            }
        }else{
            $categorias->catsuperior = NULL;
        }
        $categorias->save();

        return redirect('admin/categorias');
    }

    public function anadir(Request $request){
        $categorias = new Categorias();
        $categorias->nombre = $request->input('nombre');
        if($request->input('catsuperior')!=0){
            $categoriassuperior = Categorias::findOrFail($request->input('catsuperior'));
            if($categoriassuperior->catsuperior == NULL){
                $categorias->catsuperior = $request->input('catsuperior');
            }else{
                return redirect('admin/editarcategoria')->with('message', 'Esa categoria ya tiene un nivel superior');
            }
        }
        $categorias->save();

        return redirect('admin/categorias');
    }
}
