<?php

namespace App\Services;

use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Hash;

class UserService
{
    /**
     * جلب بيانات المستخدمين للداتاتيبل
     */
    public function getDatatable()
    {
        // تحديد البيانات بناءً على الصلاحية
        if (auth()->user()->can('viewAny', User::class)) {
            $data = User::select('id', 'name', 'email', 'status');
        } else {
            $data = User::where('id', auth()->user()->id)
                ->select('id', 'name', 'email', 'status');
        }

        return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($row) {
                $btn = '';
                if (auth()->user()->can('update', $row)) {
                    $btn .= '<a href="' . route('dashboard.users.edit', $row->id) . '" class="edit btn btn-success btn-sm"><i class="fa fa-edit"></i></a>';
                }

                // ملاحظة: الكود الأصلي كان يكرر زر الحذف مرتين، قمت بتصحيحه هنا لمرة واحدة
                if (auth()->user()->can('delete', $row)) {
                    $btn .= ' <a id="deleteBtn" data-id="' . $row->id . '" class="edit btn btn-danger btn-sm" data-toggle="modal" data-target="#deletemodal"><i class="fa fa-trash"></i></a>';
                }
                return $btn;
            })
            ->addColumn('role', function ($row) {
                return $row->status ? __('words.' . $row->status) : __('words.no_role_assigned');
            })
            ->addColumn('status_text', function ($row) {
                return $row->status == null ? __('words.not activated') : __('words.activated');
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * إنشاء مستخدم جديد
     */
    public function createUser(array $data)
    {
        // تشفير كلمة المرور
        $data['password'] = Hash::make($data['password']);

        // التأكد من أن الـ status ليس string "null" بل قيمة null حقيقية إذا كان فارغاً
        if (isset($data['status']) && $data['status'] == 'null') {
             $data['status'] = null;
        }

        return User::create($data);
    }

    /**
     * تعديل مستخدم
     */
    public function updateUser(User $user, array $data)
    {
        // التحقق مما إذا تم إرسال كلمة مرور جديدة
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            // حذف مفتاح الباسورد من المصفوفة حتى لا يتم تحديثه بـ null
            unset($data['password']);
        }

        if (isset($data['status']) && $data['status'] == 'null') {
             $data['status'] = null;
        }

        $user->update($data);

        return $user;
    }

    /**
     * حذف مستخدم
     */
    public function deleteUser($id)
    {
        // استخدام findOrfail أو التحقق المباشر
        $user = User::find($id);
        if ($user) {
            $user->delete();
            return true;
        }
        return false;
    }
}
