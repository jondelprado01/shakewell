<?php 

namespace App\Actions\DBOperations;
use App\Models\User;
use App\Models\Voucher;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Mail\WelcomeEmail;
use App\Services\StringGenerator;

class UserCRUD{
    
    public function __construct(){
        $this->user = new User();
        $this->voucher = new Voucher();
        $this->voucher->timestamps = false;
        $this->generator = new StringGenerator();
    }

    public function login($data){

        $user = $this->user->where('username', $data['username'])->first();
        return $user;
    }

    public function register($data){

        $this->user->firstname = $data['firstname'];
        $this->user->username = $data['username'];
        $this->user->email = $data['email'];
        $this->user->password = Hash::make($data['password']);
        $this->user->save();
        $user_id = $this->user->id;

        $voucher = $this->generator->generateVoucher(5);

        $this->voucher->code = $voucher;
        $this->voucher->user_id = $user_id;
        $this->voucher->save();

        Mail::to('jonathandelprado60@gmail.com')->send(new WelcomeEmail($voucher, $data['firstname']));

    }

    public function retrieve($id){
        $retrieve_vouchers = $this->voucher->where('user_id', $id)->get();
        return $retrieve_vouchers;
    }

    public function create($data){

        $voucher_count = $this->user->withCount('voucher')->where('id', $data['user_id'])->first()['voucher_count'];

        if ($voucher_count >= 10) {
            return "You already reached the limit for adding voucher.";
        }

        $voucher = $this->generator->generateVoucher(5);

        $this->voucher->code = $voucher;
        $this->voucher->user_id = $data['user_id'];
        return $this->voucher->save();

    }

    public function delete($id){

        return $this->voucher->where('id', $id)->delete();

    }

}

?>