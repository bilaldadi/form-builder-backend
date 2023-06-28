<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $forms = Form::all();

        return $forms;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'form_elements' => 'required|array',
            'form_elements.*.id' => 'required|string',
            'form_elements.*.label' => 'required|string',
            'form_elements.*.type' => 'required|string',
        ]);

        if ($validator->fails()) {
            // Log validation errors
            \Log::error('Validation errors:', $validator->errors());
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $form = Form::create([
            'form_elements' => json_encode($data['form_elements']) // Convert to JSON string
        ]);

        return response()->json($form, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Form $form)
    {
        $form->delete();

        return response()->json(null, 204);
    }
}
