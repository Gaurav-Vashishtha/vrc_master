<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Auth\employee;
use App\Auth\Spokers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Exception;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

class RegistrationController extends Controller
{   
    // This function is used for the View page where all required field for registration 
    Public function index(){
        return view('admin.Employee.Registration');
    }

    // This function is used for the New Registration of Employees
    Public function store(Request $request){
        try {
            DB::beginTransaction();
            $POST = $request->all();
            $user = Session::get('users');
            // dd($POST);

            $data = new employee();

            if ($request->hasFile('profile_photo')) {
                $file = $request->file('profile_photo');
                $allowedExt = ['jpg', 'JPG', 'png', 'PNG'];
                $ext = $file->getClientOriginalExtension();
                $size= $file->getSize();
                $check = in_array($ext, $allowedExt);

                if ($size>1000000) {
                    return response()->json(['status'=>'0', 'msg' =>"Please select only max 1mb size for Profile photos"]);
                }
                if ($check) {
                    $fileName = time() . $file->getClientOriginalName();
                    $file->move('images/employees', $fileName);
                    $data->profile_photo    =   $fileName;   
                }
                else {
                    return response()->json(['status'=>'0', 'msg' =>"Please select only JPG or PNG formate for Profile Photos"]);
                }
            }

            $data->password         =   hash::make('1234');
            $data->is_spoker        =   $request->is_spoker;
            $data->status           =   '0';
            $data->first_name       =   $request->first_name;
            $data->last_name        =   $request->last_name;
            $data->emp_code         =   $request->emp_code;
            $data->father_name      =   $request->father_name;
            $data->position         =   $request->position;
            $data->DOB              =   $request->DOB;
            $data->gender           =   $request->gender;
            $data->personal_email   =   $request->personal_email;
            $data->company_email    =   $request->company_email;
            $data->personal_mobile  =   $request->personal_mobile;
            $data->company_mobile   =   $request->company_mobile;
            $data->current_add      =   $request->current_add;
            $data->permanent_add    =   $request->permanent_add;
            $data->pincode          =   $request->pincode;
            $data->city             =   $request->city;
            $data->state            =   $request->state;
            $data->country          =   $request->country;
            $data->sallary          =   $request->sallary;
            $data->bank_name        =   $request->bank_name;
            $data->acc_no           =   $request->acc_no;
            $data->ifsc             =   $request->ifsc;
            $data->created_by       =   $user->emp_code;

            $data->save();


            if ($request->is_spoker=='1') {

                if (Spokers::where('email', $request->personal_email)->first()) {
                    return response()->json(['status'=>'0', 'msg' =>"Email - $request->personal_email is allready register for spoker."]);
                }

                $spoker = new Spokers();
                $spoker->name      = $request->first_name.' '.$request->last_name; 
                $spoker->email     = $request->personal_email;
                // $spoker->password  = hash::make($request->password);
                $spoker->password  = hash::make('1234');
                $spoker->status    = 'INACTIVE';
                // dd($spoker);
                $spoker->save();
            }
            DB::commit();
            return response()->json(['status'=>'1', 'msg' =>"Registraton Successfully !", 'data'=>$data]);
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            return response()->json(['status'=>'0', 'msg' =>"$msg", 'data'=>$data]);
        }

    }


    // Fech All Register Employee where we have Delete and Edit Options
    public function view(){
        $employee = employee::all();
        // dd($employee);
        return view('admin.Employee.index', ['data'=>$employee]);
    }

    // Delete Register Employee By his unique ID
    public function delete($id){
        $employee = employee::find($id);
        if ($employee) {
            $employee->delete();    
            return back()->with(['status'=>'1', 'msg' =>"ID - $id Employee Deleted Successfully !", 'data'=>$employee]);
        } 
        else {
            return response()->json(['status'=>'0', 'msg' =>"Error while deleting ID- $id"]);
        }
    }

    // Fetch all details of Specific user by his unique ID for Edit Register Details
    public function edit($id){
        $employee = employee::find($id);
        if ($employee) {
            return view('admin.Employee.edit', ['data'=>$employee]);
        } else {
            return response()->json(['status'=>'0', 'msg' =>"No Record found for ID- $id"]);
        }
        
    }

    // this function is used for update by Employee By his unique ID 
    public function update(Request $request, $id)
    {
        try{
            $POST = $request->all();
            $user = Session::get('users');  
            // dd($POST);
            $data = employee::find($id);

            if ($request->hasFile('profile_photo')) {
                $file = $request->file('profile_photo');
                $allowedExt = ['jpg', 'JPG', 'png', 'PNG'];
                $ext = $file->getClientOriginalExtension();
                $size= $file->getSize();
                $check = in_array($ext, $allowedExt);

                if ($size>1000000) {
                    return response()->json(['status'=>'0', 'msg' =>"Please select only max 1mb size for Profile photos"]);
                }
                if ($check) {
                    $fileName = time() . $file->getClientOriginalName();
                    $file->move('images/employees', $fileName);
                    $data->profile_photo    =   $fileName;   
                }
                else {
                    return response()->json(['status'=>'0', 'msg' =>"Please select only JPG or PNG formate for Profile Photos"]);
                }
            }

            $data->first_name       =   $request->first_name;
            $data->last_name        =   $request->last_name;
            $data->father_name      =   $request->father_name;
            $data->position         =   $request->position;
            $data->DOB              =   $request->DOB;
            $data->gender           =   $request->gender;
            $data->personal_email   =   $request->personal_email;
            $data->company_email    =   $request->company_email;
            $data->personal_mobile  =   $request->personal_mobile;
            $data->company_mobile   =   $request->company_mobile;
            $data->current_add      =   $request->current_add;
            $data->permanent_add    =   $request->permanent_add;
            $data->pincode          =   $request->pincode;
            $data->city             =   $request->city;
            $data->state            =   $request->state;
            $data->country          =   $request->country;
            $data->sallary          =   $request->sallary;
            $data->bank_name        =   $request->bank_name;
            $data->acc_no           =   $request->acc_no;
            $data->ifsc             =   $request->ifsc;
            $data->usertype         =   $request->usertype;
            $data->status           =   $request->status;
            $data->updated_by       =   $user->emp_code;

            if ($data) {
                $data->update();
                return response()->json(['status'=>'1', 'msg' =>"ID- $id Update Successfully !", 'data'=>$data]);
            }
            else {
                return response()->json(['status'=>'0', 'msg' =>"Error while updating Employee ID - $id"]);
            }
        } catch (\Exception $e) {
            $msg = $e->getMessage();
            return response()->json(['status'=>'0', 'msg' =>"$msg", 'data'=>$data]);
        }
    }
}