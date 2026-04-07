<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form;
use App\Models\FormField;
use App\Models\Submission;

class FormController extends Controller
{
    /**
     * Constructor to apply middleware
     */
    public function __construct()
    {
        // Only admin routes need auth
       // $this->middleware('auth')->except(['list', 'show', 'submit']);
    }

    /* =======================
       ADMIN: Forms CRUD
       ======================= */

    // List all forms (admin)
    public function index()
    {
        $forms = Form::latest()->paginate(10);
        return view('admin.forms.index', compact('forms'));
    }

    // Show create form page
    public function create()
    {
        return view('admin.forms.create');
    }

    // Store form
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $form = Form::create([
            'title' => $request->title,
            'status' => 1,
        ]);

        return redirect()->route('forms.index')->with('success', 'Form created successfully!');
    }

    // Show edit form page
    public function edit(Form $form)
    {
        return view('admin.forms.edit', compact('form'));
    }

    // Update form
    public function update(Request $request, Form $form)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $form->update([
            'title' => $request->title,
        ]);

        return redirect()->route('forms.index')->with('success', 'Form updated successfully!');
    }

    // Delete form
    public function destroy(Form $form)
    {
        $form->delete();
        return redirect()->back()->with('success', 'Form deleted successfully!');
    }

    /* =======================
       ADMIN: Form Fields
       ======================= */

    public function fields(Form $form)
    {
        $fields = $form->fields;
        return view('admin.forms.fields', compact('form', 'fields'));
    }

    public function fieldsStore(Request $request, Form $form)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'type' => 'required|string',
        ]);

        $options = $request->options ? json_encode(explode(',', $request->options)) : null;

        FormField::create([
            'form_id' => $form->id,
            'label' => $request->label,
            'name' => $request->name ?? null,
            'type' => $request->type,
            'required' => $request->required ?? 0,
            'validation' => $request->validation ?? null,
            'options' => $options,
        ]);

        return redirect()->back()->with('success', 'Field added successfully!');
    }

    /* =======================
       FRONTEND: Public Forms
       ======================= */

    // List forms (frontend)
    public function list()
    {
        $forms = Form::where('status', 1)->get();
        return view('forms.list', compact('forms'));
    }

    // Show single form (frontend)
    public function show(Form $form)
    {
        $form->load('fields');

        // Get last 5 submissions for this form
        $submissions = Submission::where('form_id', $form->id)
                        ->latest()
                        ->paginate(5);

        return view('forms.show', compact('form', 'submissions'));
    }

    // Submit form (frontend)
    public function submit(Request $request, Form $form)
    {
        $form->load('fields');

        $rules = [];
        $messages = [];

        foreach ($form->fields as $field) {
            $fieldName = $field->name ?? 'field_'.$field->id;

            if ($field->required) {
                $rules[$fieldName] = $field->validation ?? 'required';
                $messages[$fieldName.'.required'] = "{$field->label} is required";
            }
        }

        $validated = $request->validate($rules, $messages);

        Submission::create([
            'form_id' => $form->id,
            'user_name' => $request->input('Name') ?? null,
            'user_email' => $request->input('Email') ?? null,
            'data' => json_encode($validated),
        ]);

        return redirect()->back()->with('success', 'Form submitted successfully!');
    }
    public function showPublic($id)
{
    $form = Form::with('fields')->findOrFail($id);
    $submissions = Submission::where('form_id', $id)->latest()->paginate(5);
    return view('forms.show', compact('form', 'submissions'));
}

public function submitPublic(Request $request, $id)
{
    $form = Form::with('fields')->findOrFail($id);
    // validation + store logic
}
}