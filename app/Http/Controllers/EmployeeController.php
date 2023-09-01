<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{


    public function fetch(Request $request)
    {
        try {
            $searchTerm = $request->input('search');

            $query = Employee::query();

            if (!empty($searchTerm)) {
                $query->where('name', 'like', $searchTerm . '%');
            }

            $employees = $query->paginate(5);

            return response()->json($employees);
        } catch (Exception $e) {
            dd($e->getCode());
        }
    }

    public function insert(Request $request)
    {
        $validation = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'role' => 'required',
            'age' => 'required|integer',
            'city' => 'required',
            'image_name' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);
    
        if ($validation) {
            try {
                // Handle image upload
                if ($request->hasFile('image_name')) {
                    $image = $request->file('image_name');
                    dd($image);
                    $imageName = time() . '.' . $image->getClientOriginalExtension();
                    $image->storeAs('public/uploads', $imageName);
                } else {
                    $imageName = null; // No image uploaded
                }
    
                // Insert data into the 'employees' table
                DB::table('employees')->insert([
                    'name' => $request->name,
                    'email' => $request->email,
                    'role' => $request->role,
                    'age' => $request->age,
                    'city' => $request->city,
                    'image_name' => $imageName, 
                ]);
    
                return response()->json(['insert' => 'success']);
            } catch (Exception $e) {
                return response()->json(['insert' => 'error']);
            }
        } else {
            // Validation failed, return JSON response with validation errors
            return response()->json(['validation_errors' => $validation], 400);

        }
    }
    
    
    public function update()
    {
    }
    public function delete()
    {
    }
}
