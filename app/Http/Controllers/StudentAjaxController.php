<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InfoStudent;


class StudentAjaxController extends Controller
{
    public function index()
    {
        $students = InfoStudent::orderBy('id','DESC')->get();
        return view('student.index',compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $student=InfoStudent::create($request->all());
        // trả dữ liệu về cho ajax
        return response()->json([
            'data'=>$student,
            'message'=>'Tạo sinh viên thành công'],200); //mã trạng thái 200
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $student = InfoStudent::find($id);
        // trả dữ liệu về cho ajax
        return response()->json(['data'=>$student],200); //mã trạng thái 200
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $student=InfoStudent::find($id);
        // trả dữ liệu về cho ajax
        return response()->json(['data'=>$student],200); //mã trạng thái 200
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $student=InfoStudent::find($id)->update($request->all());
        // trả dữ liệu về cho ajax
        return response()->json([
            'data'=>$student,
            'student' => $request->all(),
            'id' => $id,
            'message'=>'Cập nhật thông tin sinh viên thành công'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        InfoStudent::find($id)->delete();
        // trả dữ liệu về cho ajax
        return response()->json(['data'=>'removed'],200); //mã trạng thái 200
    }
}
