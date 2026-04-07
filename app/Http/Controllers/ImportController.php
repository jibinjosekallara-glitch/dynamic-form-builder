<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Or Form model if importing submissions/forms
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ImportController extends Controller
{
    // Show import page
    public function index()
    {
        return view('admin.import.index');
    }

    // Handle CSV upload and preview
    public function upload(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|mimes:csv,txt'
        ]);

        $file = $request->file('csv_file');
        $rows = array_map('str_getcsv', file($file->getRealPath()));

        // Assume first row is header
        $header = array_shift($rows);

        $preview = [];
        $validRows = [];
        $invalidRows = [];

        foreach ($rows as $index => $row) {
            $data = array_combine($header, $row);

            // Example validation: name,email,role required
            $validator = Validator::make($data, [
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'role' => 'required|in:admin,user',
            ]);

            $data['valid'] = !$validator->fails();

            $preview[] = $data;

            if ($data['valid']) {
                $validRows[] = $data;
            } else {
                $invalidRows[] = $data;
            }
        }

        // Store valid rows temporarily in session for insert after confirmation
        session(['import_valid_rows' => $validRows]);

        return view('admin.import.preview', compact('header', 'preview', 'validRows', 'invalidRows'));
    }

    // Insert valid rows after admin confirmation
    public function confirm()
    {
        $validRows = session('import_valid_rows', []);

        foreach ($validRows as $row) {
            User::create([
                'name' => $row['name'],
                'email' => $row['email'],
                'role' => $row['role'],
                'password' => bcrypt('password123'), // default password
            ]);
        }

        // Clear session
        session()->forget('import_valid_rows');

        return redirect()->route('admin.dashboard')->with('success', count($validRows) . ' users imported successfully.');
    }
}