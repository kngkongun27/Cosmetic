<?php

namespace App\Http\Controllers\Front;

use App\Models\Contact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    public function index()
    {
        return view('front.contact.index', []);
    }

    public function store(Request $request)
{
    $data = new Contact();
    $data->name = $request->input('name');
    $data->email = $request->input('email');
    $data->subject = $request->input('subject');
    $data->message = $request->input('message');
    $data->save();

    return redirect()->back()->with('success', 'Gửi liên hệ thành công!');
}

}
