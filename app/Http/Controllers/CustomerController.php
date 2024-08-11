<?php

namespace App\Http\Controllers;
use App\Models\Customer;
use Illuminate\Http\Request;
use App\Imports\CustomersImport;
use Maatwebsite\Excel\Facades\Excel;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');  
 // Asegúrate de crear esta vista
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario aquí
        //dd($request);
        $request->validate([
            'customer_id' => 'required|unique:customers,id', // El ID del cliente es obligatorio, debe ser un entero y existir en la tabla 'customers'
            'first_name' => 'required|string|max:255', 
            'last_name' => 'required|string|max:255', 
            'company' => 'nullable|string|max:255', 
            'city' => 'nullable|string|max:255', 
            'country' => 'nullable|string|max:255', 
            'phone_1' => 'required|string|max:20', 
            'phone_2' => 'nullable|string|max:20', 
            'email' => 'required|email|unique:customers,email', 
            'subscription_date' => 'nullable|date', 
            'website' => 'nullable|url', 
        ]);
        
        Customer::create($request->all());

        return redirect()->route('customers.index')->with('success', 'Cliente creado exitosamente.');
    }

    public function show(Customer $customer)
    {
        return view('customers.show', compact('customer')); // Asegúrate de crear esta vista
    }

    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer')); // Asegúrate de crear esta vista
    }

    public function update(Request $request, Customer $customer)
    {
        // Validar los datos del formulario aquí
        $request->validate([
            'first_name' => 'required|string|max:255', 
            'last_name' => 'required|string|max:255', 
            'company' => 'nullable|string|max:255', 
            'city' => 'nullable|string|max:255', 
            'country' => 'nullable|string|max:255', 
            'phone_1' => 'required|string|max:20', 
            'phone_2' => 'nullable|string|max:20', 
            'email' => 'required|email', 
            'subscription_date' => 'nullable|date', 
            'website' => 'nullable|url', 
        ]);
        
        $customer->update($request->all());
        return redirect()->route('customers.index')->with('success', 'Cliente actualizado exitosamente.');
    }

    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()->route('customers.index')->with('success', 'Cliente eliminado  
 exitosamente.');
    }

    // Método para importar desde CSV (similar al que ya tenías)
    public function costumersImport(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:csv,txt'
        ]);


        Excel::import(new CustomersImport, $request->file('file'));

        return redirect()->back()->with('success', '¡Importación completada!');
    }

    public function deleteAll(){
        //dd("hi");
        // Opción 1: Eliminar todos los registros (más rápido pero menos seguro)
        Customer::truncate(); 

        // Opción 2: Eliminar registros uno por uno (más lento pero puede ser necesario para activar eventos o lógica adicional)
        // Customer::query()->delete(); 
        return redirect()->back()->with('success', 'Todos los clientes han sido eliminados.'); 
    }
}
