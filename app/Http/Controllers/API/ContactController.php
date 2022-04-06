<?php

namespace App\Http\Controllers\API;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ContactResource;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function index()
    {
        $data = Contact::latest()->get();
        return response()->json([ContactResource::collection($data), 'Contacts fetched.']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'no_hp' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $contact = Contact::create([
            'name' => $request->name,
            'no_hp' => $request->no_hp
        ]);

        return response()->json(['Contact created successfully.', new ContactResource($contact)]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $contact = Contact::find($id);
        if (is_null($contact)) {
            return response()->json('Data not found', 404);
        }
        return response()->json([new ContactResource($contact)]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contact $contact)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'no_hp' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $contact->name = $request->name;
        $contact->no_hp = $request->no_hp;
        $contact->save();

        return response()->json(['Program updated successfully.', new ContactResource($contact)]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return response()->json('Program deleted successfully');
    }
}
