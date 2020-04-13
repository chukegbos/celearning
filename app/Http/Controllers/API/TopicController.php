<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Topic;
use App\Course;
use Auth;
use Illuminate\Support\Facades\Hash;
use DB;
use Carbon\Carbon;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class TopicController extends Controller
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
        $live_class = "Live Class";
        return Topic::where('status', $live_class)->where('end_date', '>=', Carbon::now())->latest()->paginate(3);
    }

    public function past()
    {
        return Topic::latest()->paginate(6);
    }

    public function course()
    {
        return Course::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $start_time = NULL;
        $end_date = NULL;
        $link = NULL;
        $video_link = NULL;

        if ($request->status=="Live Class") {
            $this->validate($request, [
                'topic_name' => 'required|string|max:191',
                'description' => 'max:300',
                'link' => 'required|string',
                'course_code' => 'required',

                'start_time' => 'required',
                'start_date' => 'required',
                'end_time' => 'required',
                'end_date' => 'required',
            ]);
            $start_time = $request->start_date.' '.$request->start_time;
            $end_date = $request->end_date.' '.$request->end_time;
            $link = $request->link;
        }
        else
        {
            $this->validate($request, [
                'topic_name' => 'required|string|max:191',
                'description' => 'max:300',
                'course_code' => 'required',
            ]);

            if ($request->video_link) {
                $video_link = $request->video_link;
            }         
        }
        $slug = str_slug($request->topic_name, '-');
            
        $image = DB::table('images')->inRandomOrder()->first();

        return Topic::create([
            'topic_name' => $request['topic_name'],
            'topic_slug' => $slug,
            'topic_code' => rand(5, 1500000),
            'start_time' => $start_time,
            'end_date' => $end_date,
            'status' => $request['status'],
            'link' => $link,
            'video_link' => $video_link,
            'description' => $request['description'],
            'course_code' => $request['course_code'],
            'image' => $image->image,
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
        $topic = Topic::findOrFail($id);
        $start_time = NULL;
        $end_date = NULL;
        $link = NULL;
        $video_link = NULL;

        if ($request->status=="Live Class") {
            $this->validate($request, [
                'topic_name' => 'required|string|max:191',
                'description' => 'max:300',
                'link' => 'required|string',
                'course_code' => 'required',

                'start_time' => 'required',
                'start_date' => 'required',
                'end_time' => 'required',
                'end_date' => 'required',
            ]);
            $start_time = $request->start_date.' '.$request->start_time;
            $end_date = $request->end_date.' '.$request->end_time;
            $link = $request->link;
        }
        else
        {
            $this->validate($request, [
                'topic_name' => 'required|string|max:191',
                'description' => 'max:300',
                'course_code' => 'required',
            ]);
            if ($request->video_link) {
                $video_link = $request->video_link;
            }
             
        }

        $slug = str_slug($request->topic_name, '-');
        $image = DB::table('images')->inRandomOrder()->first();

        $topic->update([
            'topic_name' => $request['topic_name'],
            'topic_slug' => $slug,
            'topic_code' => rand(5, 1500000),
            'start_time' => $start_time,
            'end_date' => $end_date,
            'status' => $request['status'],
            'link' => $link,
            'video_link' => $video_link,
            'description' => $request['description'],
            'course_code' => $request['course_code'],
            'image' => $image->image,
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
        Topic::destroy($id);
    }
}
