<?php

namespace App\Http\Controllers\API;

use App\Models\Student;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class StudentController extends Controller
{
    // get all students data
    public function index(){
        $students = Student::latest()->get();
        if($students->count() > 0){
            return response()->json([
                'status'=>200,'data'=>$students
            ],200);
        }else{
            return response()->json([
                'status'=>404, 'message'=>'No Records Found!'
            ],404);
        }
    }
    // create a new student
    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'name'   =>'required|string|max:191',
            'course' =>'required|string|max:191',
            'phone'  =>'required|digits:11|unique:students',
            'email'  =>'required|email|max:191',
            'address'=>'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>422,
                'errors'=>$validator->messages()
            ],422);
        }else{
            $student = Student::create([
                'name'   =>$request->name,
                'course' =>$request->course,
                'phone'  =>$request->phone,
                'email'  =>$request->email,
                'address'=>$request->address
            ]);

            if($student){
                return response()->json([
                    'status'=>200,
                    'message'=>'Student Created Successfully'
                ],200);
            }else{
                return response()->json([
                    'status'=>500,
                    'message'=>'Something Went Wrong!'
                ],500);
            }
        }
    }
    // show student details
    public function show($id){
        $student = Student::find($id);
        if($student){
            return response()->json([
                'status'=>200,
                'student'=>$student
            ],200);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'No Such Student Found!'
            ],404);
        }
    }
    // edit student details
    public function edit($id)
    {
        $student = Student::find($id);
        if($student){
            return response()->json([
                'status'=>200,
                'student'=>$student
            ],200);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'No Such Student Found!'
            ],404);
        }
    }
    // update student data
    public function update(Request $request, $id){
        $validator = Validator::make($request->all(),[
            'name'   =>'required|string|max:191',
            'course' =>'required|string|max:191',
            'phone'  =>'required|digits:11',
            'email'  =>'required|email|max:191',
            'address'=>'required',
        ]);

        if($validator->fails()){
            return response()->json([
                'status'=>422,
                'error'=>$validator->messages()
            ],422);
        }else{
            $student = Student::find($id);
            $student->update([
                'name'   =>$request->name,
                'course' =>$request->course,
                'phone'  =>$request->phone,
                'email'  =>$request->email,
                'address'=>$request->address
            ]);

            if($student){
                return response()->json([
                    'status'=>200,
                    'message'=>'Student Updated Successfully'
                ],200);
            }else{
                return response()->json([
                    'status'=>500,
                    'message'=>'Something Went Wrong!'
                ],500);
            }
        }
    }
    // delete student
    public function destroy($id)
    {
        $student = Student::find($id);
        if($student){
            $student->delete();
            return response()->json([
                'status'=>200,
                'message'=>'Studernt Deleted Successfully'
            ],200);
        }else{
            return response()->json([
                'status'=>404,
                'message'=>'No Such Student Found!'
            ],400);
        }
    }
}