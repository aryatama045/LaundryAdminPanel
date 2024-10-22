<?php

namespace App\Repositories;

use App\Http\Requests\ContactRequest;
use App\Models\Contact;

class ContactRepository extends Repository
{
    public function model()
    {
        return Contact::class;
    }

    public function getAll()
    {
       return $this->model()::latest('id')->get();
    }

    public function storeByRequest(ContactRequest $request): Contact
    {
        return $this->model()::create([
                    'name' => $request->name,
                    'phone_number' => $request->phone_number,
                    'email' => $request->email,
                    'message' => $request->message
                ]);
    }


}
