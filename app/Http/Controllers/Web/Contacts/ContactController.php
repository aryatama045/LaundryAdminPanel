<?php

namespace App\Http\Controllers\Web\Contacts;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Repositories\ContactRepository;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $contacts = (new ContactRepository)->getAll();
        return view('contacts.index',compact('contacts'));
    }
}
