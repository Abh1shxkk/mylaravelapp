<?php

namespace App\Http\Controllers;
use App\Models\student;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class Usercontroller4
{
   public function index(Request $request)
    {
        if ($request->isMethod('post')) {
            $request->validate([
                'username' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:userdata,email',
                'phone' => 'required|string|max:15',
                'image' => 'nullable|image|max:2048', // Image validation (optional, max 2MB)
            ]);

            $student = new Student();
            $student->name = $request->input('username');
            $student->email = $request->input('email');
            $student->phone = $request->input('phone');

            // Image upload logic
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('uploads', 'public'); // Save in storage/app/public/uploads
                $student->image = $imagePath; // Store path in database
            }

            $student->save();

            return redirect()->route('crud.index')->with('success', 'Data inserted successfully!');
        }

        $search = $request->query('search');
        $students = Student::query()
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%')
                             ->orWhere('email', 'like', '%' . $search . '%')
                             ->orWhere('phone', 'like', '%' . $search . '%');
            })
            ->paginate(5);

        return view('crudgetdata', ['studentdata' => $students]);
    }

    function delete($id)
    {

        $deleted = student::destroy($id);

        if ($deleted) {
            return redirect('crudgetdata');
        }
    }

    function edit($id)
    {

        $student = student::find($id);
        return view('crudedit', ["user" => $student]);

    }

    function update(Request $request, $id)
   {
        $request->validate([
            'username' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:userdata,email,' . $id,
            'phone' => 'required|string|max:15',
            'image' => 'nullable|image|max:2048', // Image validation (optional)
        ]);

        $student = Student::find($id);
        $student->name = $request->input('username');
        $student->email = $request->input('email');
        $student->phone = $request->input('phone');

        // Image update logic
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($student->image) {
                Storage::disk('public')->delete($student->image);
            }
            $imagePath = $request->file('image')->store('uploads', 'public');
            $student->image = $imagePath;
        }

        if ($student->save()) {
            return redirect('crudgetdata')->with('success', 'Data updated successfully!');
        } else {
            return redirect('crudgetdata')->with('error', 'Data update failed!');
        }
    }

function deleteMultiple(Request $request)
{
    $ids = $request->input('ids', []);
    if (!empty($ids)) {
        student::destroy($ids);
    }
    return redirect('crudgetdata');
}

}
