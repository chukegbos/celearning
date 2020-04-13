<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Topic_Category;
use Illuminate\Support\Facades\Hash;

class ForumCategory extends Controller
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
        return Topic_Category::where('deleted_at', NULL)->latest()->paginate(10);
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
        ]);

        $slug = str_slug($request->name, '-');

        return Topic_Category::create([
            'name' => $request['name'],
            'slug' => $slug,
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
        $Topic_Category = Topic_Category::findOrFail($id);
        $this->validate($request, [
            'name' => 'required|string|max:191',
        ]);

        $slug = str_slug($request->name, '-');

        $Topic_Category->update([
            'name' => $request['name'],
            'slug' => $slug,
        ]);
        return ['Message' => 'Updated'];
    }


    public function search()
    {
        if ($search = \Request::get('q')) {
            $Topic_Category = Topic_Category::where(function($query) use ($search){
                $query->where('name', 'LIKE', "%$search%");
            })->paginate(10);
        }
        return $Topic_Category;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        Topic_Category::destroy($id);
        return ['Message' => 'Deleted'];
    }
}
