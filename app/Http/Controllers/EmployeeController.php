<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Client\ResponseSequence;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employee = Employee::all();
        return response()->json($employee);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'=> 'unique:employees|required|max:255',
            'email'=> 'required|max:255',
            'phone'=> 'required|max:255',

        ]);

        if($request->photo){
            $position = strpos($request->photo,';');
            $sub = substr($request->photo, 0, $position);
            $ext = explode('/',$sub)[1];
            $name = time().".".$ext;
            $img = Image::make($request->photo)->resize(240,200);
            $upload_path = 'backend/employee/';
            $image_url = $upload_path.$name;
            $img->save($image_url);
            Employee::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'salary' => $request->salary,
                'address' => $request->address,
                'nid' => $request->nid,
                'joining_date' => $request->joining_date,
                'photo' => $image_url
            ]);
        }
        else{
            Employee::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'salary' => $request->salary,
                'address' => $request->address,
                'nid' => $request->nid,
                'joining_date' => $request->joining_date,
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
        $employee = Employee::findOrFail($id);
        return response()->json($employee);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        $image = $request->newPhoto;
        if($image){
            $position = strpos($image,';');
            $sub = substr($image, 0, $position);
            $ext = explode('/',$sub)[1];
            $name = time().".".$ext;
            $img = Image::make($image)->resize(240,200);
            $upload_path = 'backend/employee/';
            $image_url = $upload_path.$name;
            $img->save($image_url);
            unlink($employee->photo);
            $employee->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'salary' => $request->salary,
                'address' => $request->address,
                'nid' => $request->nid,
                'joining_date' => $request->joining_date,
                'photo' => $image_url
            ]);
        } else{
            $employee->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'salary' => $request->salary,
                'address' => $request->address,
                'nid' => $request->nid,
                'joining_date' => $request->joining_date,
                'photo' => $employee->photo
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $photo = $employee->photo;
        if($photo){
            unlink($photo);
        }
        $employee->delete();
    }
}
