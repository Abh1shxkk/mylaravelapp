<?php

namespace App\Http\Controllers;
use App\Models\student;

use Illuminate\Http\Request;

class Usercontroller4
{
    function add(Request $request)
    {

        $students = new student();
        $students->name = $request->input('username');
        $students->email = $request->input('email');
        $students->phone = $request->input('phone');
        $students->save();


        if ($students) {
            return redirect('crudgetdata');
        } else {
            return "not added";
        }
    }
    function getdata(Request $request)
    {
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


        $students = Student::find($id);
        $students->name = $request->input('username');
        $students->email = $request->input('email');
        $students->phone = $request->input('phone');
        // $students->save();
        if ($students->save()) {
            return redirect('crudgetdata');
        } else {

            return " did not update";
        }
    }

function deleteMultiple(Request $request)
{
    $ids = $request->input('ids', []);
    if (!empty($ids)) {
        Student::destroy($ids);
    }
    return redirect('crudgetdata');
}

}
