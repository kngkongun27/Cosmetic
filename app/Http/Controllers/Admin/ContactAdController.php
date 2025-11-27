<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contact;

class ContactAdController extends Controller
{
    public function index(Request $request)
    {
        $query = Contact::query();

        // Tìm kiếm theo tên hoặc email hoặc subject
        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('subject', 'like', "%{$search}%");
        }

        // Pagination, ví dụ 10 item mỗi trang
        $contacts = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.contact.index', compact('contacts'));
    }

    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        return redirect()->route('admin.contact.index')->with('success', 'Liên hệ đã được xóa!');
    }
}
