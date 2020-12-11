<?php

namespace Modules\AdminUser\Http\Controllers\Api;

use Modules\AdminUser\Services\AdminUserService;
use Modules\AdminUser\Http\Resources\Api\AdminUserResource;
use Modules\AdminUser\Http\Resources\Api\AdminUserListResource;
use Modules\AdminUser\Http\Requests\Api\UpdateAdminUserRequest;
use Modules\AdminUser\Http\Requests\Api\StoreAdminUserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdminUserController extends Controller
{

    protected $service;
    protected $user;

    public function __construct(
        AdminUserService $service
    ) {
        $this->service = $service;
        $this->user = Auth::guard('admin_api')->user();
    }

    /**
     * Display the current user details
     *
     * @return CurrentUserResource
     */
    public function currentUser()
    {
        return new AdminUserResource(Auth::guard('admin_api')->user());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return AdminUserListResource::collection($this->service->all());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdminUserRequest $request)
    {
        $attributes = $request->all();

        return $this->service->store($attributes);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request)
    {
        $attributes = $request->all();

        return $this->service->updatePassword($this->user, $attributes);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new AdminUserResource($this->service->getById($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id, UpdateAdminUserRequest $request)
    {

        $attributes = $request->all();

        $this->service->update($id, $attributes);

        return $this->service->getById($id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->service->deleteMultiple($request->id);
    }

}
