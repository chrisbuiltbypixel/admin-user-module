<?php

namespace Modules\AdminUser\Http\Controllers\Api;

use Modules\AdminUser\Services\AdminUserService;
use Modules\AdminUser\Http\Resources\Api\AdminUserResource;
use Modules\AdminUser\Http\Resources\Api\AdminUserListResource;
use Modules\AdminUser\Http\Requests\Api\UpdateAdminUserRequest;
use Illuminate\Support\Facades\Log;
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

        try {
            $this->service->store($attributes);
            return response()->success('This action has been completed successfully');
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return response()->error('This action could not be completed');
        }

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

        try {
            $this->service->update($id, $attributes);
            return response()->success('This action has been completed successfully');
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return response()->error('This action could not be completed');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {

        try {
            $attributes = $request->json()->all();
            $this->service->destroy($attributes);
            return response()->success('This action has been completed successfully');
        } catch (\Exception $e) {
            Log::info($e->getMessage());
            return response()->error('This action could not be completed');
        }

    }

}
