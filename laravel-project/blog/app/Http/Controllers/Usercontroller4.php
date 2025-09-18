<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class UserController4
{
    public function index(Request $request)
    {
        if ($request->isMethod('post')) {
            try {
                $validatedData = $request->validate([
                    'username' => 'required|string|max:255',
                    'email' => 'required|email|max:255|unique:userdata,email',
                    'phone' => 'required|string|max:15',
                    'image' => 'nullable|image|max:10000',
                ], [
                    'username.required' => 'The name field is required.',
                    'email.required' => 'The email field is required.',
                    'email.email' => 'Please enter a valid email address.',
                    'email.unique' => 'This email is already taken.',
                    'phone.required' => 'The phone field is required.',
                    'image.image' => 'The file must be an image.',
                    'image.max' => 'The image size must not exceed 10MB.',
                ]);

                $student = new Student();
                $student->name = $validatedData['username'];
                $student->email = $validatedData['email'];
                $student->phone = $validatedData['phone'];

                if ($request->hasFile('image')) {
                    $imagePath = $request->file('image')->store('uploads', 'public');
                    if ($imagePath) {
                        $student->image = $imagePath;
                    } else {
                        Log::error('Image upload failed in index for new record');
                        return response()->json(['success' => false, 'message' => 'Image upload failed!'], 400);
                    }
                }

                $student->save();

                $imageUrl = $student->image ? asset('storage/' . $student->image) : null;
                return response()->json([
                    'success' => true,
                    'message' => 'Data inserted successfully!',
                    'data' => [
                        'id' => $student->id,
                        'name' => $student->name,
                        'email' => $student->email,
                        'phone' => $student->phone,
                        'image_url' => $imageUrl
                    ]
                ]);
            } catch (\Illuminate\Validation\ValidationException $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed!',
                    'errors' => $e->errors()
                ], 422);
            } catch (\Exception $e) {
                Log::error('Unexpected error in index: ' . $e->getMessage());
                return response()->json(['success' => false, 'message' => 'An unexpected error occurred!'], 500);
            }
        }

        $search = $request->query('search');
        $students = Student::query()
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%');
            })
            ->orderBy('id', 'desc') // Changed to sort by id DESC
            ->paginate(6); // Updated to match getTableData pagination

        return view('crudgetdata', ['studentdata' => $students]);
    }

    public function ajaxUpdate(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'username' => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:userdata,email,' . $id,
                'phone' => 'required|string|max:15',
                'image' => 'nullable|image|max:10000',
            ]);

            $student = Student::find($id);
            if (!$student) {
                return response()->json(['success' => false, 'message' => 'Record not found!'], 404);
            }

            $student->name = $validatedData['username'];
            $student->email = $validatedData['email'];
            $student->phone = $validatedData['phone'];

            if ($request->hasFile('image')) {
                if ($student->image) {
                    Storage::disk('public')->delete($student->image);
                }
                $imagePath = $request->file('image')->store('uploads', 'public');
                $student->image = $imagePath;
            }

            $student->save();

            return response()->json(['success' => true, 'message' => 'Record updated successfully!']);
        } catch (\Exception $e) {
            Log::error('AJAX Update Error for ID ' . $id . ': ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Update failed: ' . $e->getMessage()], 500);
        }
    }

    public function ajaxDelete($id)
    {
        try {
            $student = Student::find($id);
            if ($student) {
                if ($student->image) {
                    Storage::disk('public')->delete($student->image);
                }
                $student->delete();
                return response()->json(['success' => true, 'message' => 'Record deleted successfully!']);
            }
            return response()->json(['success' => false, 'message' => 'Record not found!'], 404);
        } catch (\Exception $e) {
            Log::error('AJAX Delete Error for ID ' . $id . ': ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Delete failed!'], 500);
        }
    }

public function getTableData(Request $request)
{
    $search = $request->query('search');
    $students = Student::query()
        ->when($search, function ($query, $search) {
            return $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('email', 'like', '%' . $search . '%')
                ->orWhere('phone', 'like', '%' . $search . '%');
        })
        ->orderBy('id', 'desc') // Changed to sort by id DESC
        ->paginate(5);

    $rows = [];
    foreach ($students as $sd) {
        $imageHtml = $sd->image ? '<img src="' . asset('storage/' . $sd->image) . '" alt="User Image" class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">' : '<span class="text-muted">No Image</span>';
        $operations = '<a href="#" class="btn btn-sm btn-warning edit-btn" data-id="' . $sd->id . '" data-name="' . htmlspecialchars($sd->name) . '" data-email="' . htmlspecialchars($sd->email) . '" data-phone="' . htmlspecialchars($sd->phone) . '" data-image="' . ($sd->image ? asset('storage/' . $sd->image) : '') . '">Edit</a> <a href="#" class="btn btn-sm btn-danger delete-btn" data-id="' . $sd->id . '">Delete</a>';
        $rows[] = [
            'id' => $sd->id,
            'image' => $imageHtml,
            'name' => $sd->name,
            'email' => $sd->email,
            'phone' => $sd->phone,
            'operations' => $operations
        ];
    }

    return response()->json([
        'success' => true,
        'rows' => $rows,
        'pagination' => [
            'current_page' => $students->currentPage(),
            'last_page' => $students->lastPage(),
            'per_page' => $students->perPage(),
            'total' => $students->total()
        ]
    ]);
}
}