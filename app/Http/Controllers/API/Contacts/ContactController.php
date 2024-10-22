<?php

namespace App\Http\Controllers\API\Contacts;

use App\Http\Controllers\Controller;
use App\Http\Requests\ContactRequest;
use App\Models\Contact;
use App\Repositories\ContactRepository;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public $contactRepo;
    public function __construct(ContactRepository $contactRepository)
    {
        $this->contactRepo = $contactRepository;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContactRequest $request)
    {
       $this->contactRepo->storeByRequest($request);
      return  $this->json('Contact Success','Message send successfully');
    }
}
