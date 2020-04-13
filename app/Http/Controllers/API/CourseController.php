<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Course;
use Illuminate\Support\Facades\Hash;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('api');
    }

    public function index()
    {
        return Course::latest()->paginate(6);
        return ['Message' => 'Updated'];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'course_code' => 'required|string|unique:courses',
        ]);

        return Course::create([
            'name' => $request['name'],
            'course_code' => $request['course_code'],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $user = Course::findOrFail($id);
        $this->validate($request, [
            'name' => 'required|string|max:191',
            'course_code' => 'required|string|unique:courses',
        ]);

        $user->update([
            'name' => $request['name'],
            'course_code' => $request['course_code'],
        ]);
        return ['Message' => 'Updated'];
    }


    public function search()
    {
        if ($search = \Request::get('q')) {
            $courses = Course::where(function($query) use ($search){
                $query->where('name', 'LIKE', "%$search%")->orWhere('course_code', 'LIKE', "%$search%");
            })->paginate(6);
        }
        return $courses;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Course::destroy($id);
    }
}
