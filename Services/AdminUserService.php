<?php

namespace Modules\AdminUser\Services;

use Modules\AdminUser\Entities\AdminUser;
use Illuminate\Support\Facades\Hash;

class AdminUserService extends BaseService
{
    protected $query;

    public function __construct(AdminUser $model)
    {
        $this->model = $model;
        parent::__construct($model);
    }

    /**
     * update users password
     *
     * @param integer $id
     * @param array $attributes
     * @return json
     */
    public function updatePassword($user, $attributes)
    {
        if (Hash::check($attributes['old_password'], $user->password)) {
            $user->password = Hash::make($attributes['new_password']);
            $user->save();
            return response()->success('This action has been completed successfully');
        } else {
            return response()->error('This action could not be completed');
        }
    }

}
