<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form;
use App\Models\Submission;

class SubmissionController extends Controller
{
    // ==========================
    // Admin: list (Pagination + Filter)
    // ==========================
    public function index(Request $request)
    {
        $query = Submission::with('form');

        // 🔍 Filter by form
        if ($request->form_id) {
            $query->where('form_id', $request->form_id);
        }

        // 🔍 Filter by name
        if ($request->name) {
            $query->where('user_name', 'like', '%' . $request->name . '%');
        }

        // 🔍 Filter by email
        if ($request->email) {
            $query->where('user_email', 'like', '%' . $request->email . '%');
        }

        // 🔍 Filter by date
        if ($request->date) {
            $query->whereDate('created_at', $request->date);
        }

        $submissions = $query->latest()->paginate(10)->withQueryString();

        $forms = Form::all();

        return view('admin.submissions.index', compact('submissions', 'forms'));
    }

    // ==========================
    // Admin: show single submission
    // ==========================
    public function show(Submission $submission)
    {
        $submission->load('form.fields');
        return view('admin.submissions.show', compact('submission'));
    }

    // ==========================
    // Admin: delete submission
    // ==========================
    public function destroy($id)
    {
        Submission::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Submission deleted successfully.');
    }

    // ==========================
    // User: show form
    // ==========================
    public function form($id)
    {
        $form = Form::with('fields')->findOrFail($id);
        return view('submission.show', compact('form'));
    }

    // ==========================
    // User: submit form
    // ==========================
    public function submit(Request $request, $formId)
    {
        $form = Form::with('fields')->findOrFail($formId);

        $rules = [];

        foreach ($form->fields as $field) {
            $fieldName = $field->name ?? 'field_'.$field->id;

            if ($field->required) {
                $rules[$fieldName] = $field->validation ?? 'required';
            }
        }

        $data = $request->validate($rules);

        Submission::create([
            'form_id' => $form->id,
            'user_name' => $data['field_1'] ?? null, // adjust if needed
            'user_email' => $data['field_2'] ?? null,
            'data' => json_encode($data),
        ]);

        return redirect()->back()->with('success', 'Form submitted successfully!');
    }
}