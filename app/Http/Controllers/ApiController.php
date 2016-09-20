<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Photo;
use Hash;
use Tyson\JWTAuth\Exceptions\JWTexception;
use JWTAuth;
use App\Http\Controllers\Controller;
use Validator;
use App\Http\Requests;
use DB;

class ApiController extends Controller
{
	public function register(Request $request)
    {        
    	$input = $request->all();
    	$input['password'] = Hash::make($input['password']);
    	User::create($input);
        return response()->json(['result'=>true]);
    }
    public function authenticate(Request $request){
    	$credentials = $request->only('email', 'password');
    	 $defaultValidate = [
                'email' => 'email|max:255',
                'password' => 'required|min:6',
            ];
        $dataValidate['email'] = $request['email'];
        $dataValidate['password'] = $request['password'];
        $validator = Validator::make($dataValidate, $defaultValidate);
        if ($validator->fails()) {
            return r_response($validator->errors(), 'E0000003', $validator->errors());
        }
    	try{
    		if(!$token = JWTAuth::attempt($credentials)) {
    			return r_response(['User credentials are not correct'],'E000001','Error');
    		}
    	} catch (JWTException $ex) {
    		return r_response(['JWTException'],'E000002','Error');
    	}
    	$data = [];
    	$data['token'] = $token;
    	$user = User::select('*')->where('email',$request['email'])
    						   ->first()->toArray();
    	$data['user'] = $user;
    	return r_response($data,'S000001','Successfully');
    }
    // api create-photo
    public function getUser(Request $request){
    	$user = JWTAuth::parseToken()->toUser()->toArray();
    	return $user;
    }
    public function createPhoto(Request $request){
    	$user = JWTAuth::parseToken()->toUser()->toArray();
    	if($user['role'] != User::SMO){
    		return r_response(['you does not have permission'],'E000001','Errors');
    	}
    	$photos = $request['photos'];
    	$path = ('\\public\\img\\template');
    	$data = array();
    	if (!empty($photos)) {
            foreach ($photos as $key => $photo) {
            	$photo_name = $request['stage_id'].'.'.$request['turn_number'].'.'.rand(0,9999).$photo->getClientOriginalName();
          		$pht = new Photo();
                $pht->user_id = $user['id'];
                $pht->research_id = $request['research_id'];
                $pht->medical_institution_id = $request['medical_institution_id'];
                $pht->patient_id = $request['patient_id'];
                $pht->stage_id = $request['stage_id'];
                $pht->turn_number = $request['turn_number'];
                $pht->photo_type = $photo->getClientOriginalExtension();
                $pht->photo_path = $path.'\\'.$photo_name;
                $pht->created_at = date('Y-m-d H:i:s');
                $pht->created_by = $user['id'];
                $pht->save();
                if(!$pht->save()){
                    return r_response(["Save image $key error"], 'E0000002', 'Error');
                }
                $photo->move($path, $photo_name);
                array_push($data, $pht);
            }
        }
        return r_response($data,'S000001','Successfully');
    }
    public function listPhoto(Request $request){
    	$lists = Photo::select('photo.id','photo.user_id','photo.research_id','photo.medical_institution_id','photo.patient_id','photo.stage_id','photo.turn_number','photo.photo_type','photo.photo_path','stage.stage_name')
                        ->join('stage','photo.stage_id','=','stage.id')
    					->where('photo.user_id','=',1)
    					->where('photo.research_id','=',$request['research_id'])
    					->where('photo.patient_id','=',$request['patient_id'])
    					->get()->toArray();
        $group_types = [];
        array_sort_asc_by_column($lists,'turn_number');
        foreach ($lists as $key) {
            $group_types[$key['stage_name']][] = $key;
        }
    	return r_response($group_types,'S000001','Successfully');
    }
}              