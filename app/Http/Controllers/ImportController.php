<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\CustomersImport;
use Maatwebsite\Excel\Facades\Excel;


class ImportController extends Controller
{
    
    public function  show(){
        return view('importarcsv'); // Asegúrate de crear esta vista
    }
   
    public function store(Request $request){
        $request->validate([
           'file' => 'required|mimes:csv,txt'
       ]);
  
       Excel::import(new CustomersImport, $request->file('file'));   
        return redirect()->back()->with('success', '¡Importación completada!');
    }

}
