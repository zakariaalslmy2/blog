<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Services\UserService;

class UserController extends Controller
{
    protected $userService;

    /**
     * حقن السيرفس داخل الكنترولر
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;

        // يمكنك وضع middleware الصلاحيات هنا أو داخل الدوال
        // $this->authorizeResource(User::class, 'user');
    }

    public function index()
    {
        return view('dashboard.users.index');
    }

    public function getUsersDatatable()
    {
        return $this->userService->getDatatable();
    }

    public function create()
    {
        return view('dashboard.users.add');
    }

    /**
     * التخزين باستخدام StoreUserRequest
     */
    public function store(StoreUserRequest $request)
    {
        $this->authorize('create', User::class); // أو update حسب منطقك القديم

        // نمرر البيانات المصدقة فقط للسيرفس
        $this->userService->createUser($request->validated());

        return redirect()->route('dashboard.users.index');
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user);
        return view('dashboard.users.edit', compact('user'));
    }

    /**
     * التحديث باستخدام UpdateUserRequest
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        $this->authorize('update', $user);

        $this->userService->updateUser($user, $request->validated());

        return redirect()->route('dashboard.users.index');
    }

    /**
     * الحذف
     */
    public function delete(Request $request)
    {
        // ملاحظة: يفضل استخدام Route Model Binding (destroy(User $user))
        // ولكن سأبقيها كما هي لكي تعمل مع المودال الموجود لديك حالياً

        $this->authorize('delete', User::class); // تأكد من السياسة هنا

        if ($request->filled('id') && is_numeric($request->id)) {
            $this->userService->deleteUser($request->id);
        }

        return redirect()->route('dashboard.users.index');
    }
}