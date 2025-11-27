<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Ultilities\Common;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Service\User\UserServiceInterface;

class UserController extends Controller
{
    private $userService;

    public function __construct(UserServiceInterface $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = $this->userService->searchAndPaginate('name', $request->get('search'));


        //return $users;

        return view('admin.user.index', [
            'users' => $users,
        ]);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->get('password') != $request->get('password_confirmation')) {
            return back()->with('notification', 'Lỗi: Mật khẩu xác nhận không trùng khớp');
        }

        $data = $request->all();
        $data['password'] = bcrypt($request->get('password'));

        // Xử lý file 
        if ($request->hasFile('image')) {
            // Lưu file vào storage/app/public/user
            $path = $request->file('image')->store('public/user');

            // Lưu vào DB dưới dạng: 'user/filename.jpg'
            $data['avatar'] = str_replace('public/', '', $path);
        }

        $user = $this->userService->create($data);



        return redirect('admin/user/' . $user->id);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return view('admin.user.show', [
            'user' => $user,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('admin.user.edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $data = $request->all();

        // Xử lý mật khẩu
        if ($request->get('password') != null) {
            if ($request->get('password') != $request->get('password_confirmation')) {
                return back()
                    ->with('notification', 'Mật khẩu xác nhận không khớp!');
            }

            $data['password'] = bcrypt($request->get('password'));
        } else {
            unset($data['password']);
        }

        // Xử lý khi cập nhật file ảnh
        if ($request->hasFile('image')) {
            // Upload ảnh mới vào storage/user
            $image = $request->file('image');
            $fileName = time() . '-' . Str::slug(pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $image->getClientOriginalExtension();

            // Lưu vào storage/app/public/user
            $path = $image->storeAs('public/user', $fileName);

            // Lưu đường dẫn vào DB (chỉ lưu phần sau 'storage/')
            $data['avatar'] = 'storage/user/' . $fileName;

            // Xóa ảnh cũ nếu có
            if ($request->filled('image_old')) {
                $oldPath = str_replace('storage/', 'public/', $request->get('image_old'));
                if (Storage::exists($oldPath)) {
                    Storage::delete($oldPath);
                }
            }
        }
        // Update Data
        $this->userService->update($data, $user->id);

        return redirect('admin/user/' . $user->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        // Lưu tạm tên file cũ
        $file_name = $user->avatar;

        // Xóa bản ghi user trong DB
        $this->userService->delete($user->id);

        // Xóa file ảnh nếu tồn tại
        if (!empty($file_name)) {
            $path = storage_path('app/public/user/' . $file_name);
            if (file_exists($path)) {
                unlink($path);
            }
        }

        return redirect('admin/user')->with('success', 'Xóa người dùng thành công!');
    }
}
