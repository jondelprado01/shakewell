<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\RegisterRequestValidation;
use App\Http\Requests\LoginRequestValidation;
use App\Http\Requests\VoucherRequestValidation;
use App\Actions\DBOperations\UserCRUD;
use Auth;

class UserController extends Controller
{

    public function __construct(){
        $this->crud = new UserCRUD();
    }

    public function login(LoginRequestValidation $request){
        try {
            $validator = $request->validated();
            
            $userlogin = $this->crud->login($validator);

            Auth::login($userlogin);

            return $userlogin;

        } catch (\Exception $e) {
            return response()->json(array(
                "status" => "Error",
                "message" => $e->getMessage(),
            ));
        }
    }

    public function register(RegisterRequestValidation $request){
        try {

            $validator = $request->validated();

            $register = $this->crud->register($validator);

            return $register;

        } catch (\Exception $e) {
            return response()->json(array(
                "status" => "Error",
                "message" => $e->getMessage(),
            ));
        }
    }

    public function listVoucher(){

        $vouchers = $this->crud->retrieve(Auth::user()->id);

        return $vouchers;
    }

    public function addVoucher(VoucherRequestValidation $request){

        try {

            $validator = $request->validated();

            $create_voucher = $this->crud->create($validator);

            return $create_voucher;

        } catch (\Exception $e) {
            return response()->json(array(
                "status" => "Error",
                "message" => $e->getMessage(),
            ));
        }

    }

    public function deleteVoucher($id){

        $delete_voucher = $this->crud->delete($id);
        
        return $id;

    }

    public function logout(){
        return Auth::logout();
    }

}
