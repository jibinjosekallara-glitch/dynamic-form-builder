<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Form;
use App\Models\FormField;
use App\Models\Submission;

class FormController extends Controller
{
    // ==========================
    // Admin: Forms CRUD
    // ==========================
    public function index()
    {
        $forms = Form::paginate(10); // list all forms
        return view('admin.forms.index', compact('forms'));
    }

    public function create()
    {
        return view('admin.forms.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'status' => 'required|boolean'
        ]);

        $form = Form::create($request->only('title','status'));

        // Add default fields (Name, Email, Phone)
        // FormField::insert([
        //     ['form_id'=>$form->id, 'label'=>'Name', 'type'=>'text','required'=>1,'validation'=>'required','order'=>1,'created_at'=>now(),'updated_at'=>now()],
        //     ['form_id'=>$form->id, 'label'=>'Email', 'type'=>'email','required'=>1,'validation'=>'required|email','order'=>2,'created_at'=>now(),'updated_at'=>now()],
        //     ['form_id'=>$form->id, 'label'=>'Phone', 'type'=>'text','required'=>1,'validation'=>'required|numeric','order'=>3,'created_at'=>now(),'updated_at'=>now()],
        // ]);

        return redirect()->route('forms.index')->with('success','Form created successfully.');
    }

    public function edit(Form $form)
    {
        return view('admin.forms.edit', compact('form'));
    }

    public function update(Request $request, Form $form)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'status' => 'required|boolean'
        ]);

        $form->update($request->only('title','status'));
        return redirect()->route('forms.index')->with('success','Form updated successfully.');
    }

    public function destroy(Form $form)
    {
        $form->delete();
        return redirect()->route('forms.index')->with('success','Form deleted successfully.');
    }

    // ==========================
    // Admin: Dynamic Fields
    // ==========================
    public function fields(Form $form)
    {
        $fields = $form->fields()->orderBy('order')->get();
        return view('admin.forms.fields', compact('form', 'fields'));
    }

    public function fieldsStore(Request $request, Form $form)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'type' => 'required|in:text,textarea,number,email,date,dropdown,checkbox',
            'required' => 'required|boolean',
            'validation' => 'nullable|string',
            'options' => 'nullable|string',
            'order' => 'nullable|integer',
        ]);

        $form->fields()->create([
            'label' => $request->label,
            'type' => $request->type,
            'required' => $request->required,
            'validation' => $request->validation,
            'options' => $request->options 
                ? json_encode(array_map('trim', explode(',', $request->options))) 
                : null, // convert comma-separated string to JSON array
            'order' => $request->order ?? 0,
        ]);

        return redirect()->back()->with('success', 'Field added successfully!');
    }

    // ==========================
    // Public: Dynamic Form Submission
    // ==========================
    // Show form to users
    public function show($id)
    {
        $form = Form::with('fields')->findOrFail($id);

        // Decode options safely
        foreach ($form->fields as $field) {
            if ($field->options && is_string($field->options)) {
                $field->options = json_decode($field->options, true);
            }
        }

        // Get submissions
        $submissions = Submission::where('form_id', $id)
        ->latest()
        ->paginate(5);

        return view('forms.show', compact('form', 'submissions'));
    }

    // ==========================
    // Submit Form
    // ==========================
    public function submit(Request $request, $id)
{
    $form = Form::with('fields')->findOrFail($id);

    $rules = [];
    $messages = [];

    foreach ($form->fields as $field) {

        $fieldName = $field->name ?? 'field_'.$field->id;

        $fieldRules = [];

        // Required
        if ($field->required) {
            $fieldRules[] = 'required';
        }

        // Type-based validation
        if ($field->type == 'email') {
            $fieldRules[] = 'email';
        }

        if ($field->type == 'number') {
            $fieldRules[] = 'numeric';
        }

        // Extra validation from DB (ex: min:3|max:50)
        if (!empty($field->validation)) {
            $extraRules = explode('|', $field->validation);
            $fieldRules = array_merge($fieldRules, $extraRules);
        }

        // Checkbox fix
        if ($field->type == 'checkbox') {
            $fieldRules[] = 'array';
        }

        $rules[$fieldName] = $fieldRules;

        // Custom message (optional)
        $messages[$fieldName.'.required'] = $field->label . ' is required';
      
    }

    $validated = $request->validate($rules, $messages);

    // Save submission
    Submission::create([
        'form_id' => $form->id,
        'data' => json_encode($validated),
    ]);

    return back()->with('success', 'Form submitted successfully!');
}
    public function list()
    {
        // Only active forms
        $forms = Form::where('status', 1)->latest()->get();

        return view('forms.list', compact('forms'));
    }
}