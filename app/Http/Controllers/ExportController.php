<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Form;
use App\Models\Submission;
use Illuminate\Support\Facades\Response;

class ExportController extends Controller
{
    // Show export page (choose what to export)
    public function index()
    {
        return view('admin.export.index');
    }

    // Export users as CSV
    public function users(Request $request)
    {
        $users = User::all(['name', 'email', 'role', 'created_at']);

        $filename = "users_export_" . date('Y-m-d_H-i-s') . ".csv";

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($users) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Name', 'Email', 'Role', 'Created At']);

            foreach ($users as $user) {
                fputcsv($file, [
                    $user->name,
                    $user->email,
                    $user->role,
                    $user->created_at,
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }

    // Export submissions as CSV
    public function submissions(Request $request)
    {
        $submissions = Submission::all(); // Adjust fields as needed

        $filename = "submissions_export_" . date('Y-m-d_H-i-s') . ".csv";

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() use ($submissions) {
            $file = fopen('php://output', 'w');
            // Adjust columns based on your submissions table
            fputcsv($file, ['Form ID', 'User Name', 'User Email', 'Data', 'Submitted At']);

            foreach ($submissions as $s) {
                fputcsv($file, [
                    $s->form_id,
                    $s->user_name,
                    $s->user_email,
                    $s->data,
                    $s->created_at,
                ]);
            }

            fclose($file);
        };

        return Response::stream($callback, 200, $headers);
    }
}