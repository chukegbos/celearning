<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Support\Facades\Hash;

class ProductController extends Controller
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
        return Product::where('deleted_at', NULL)->latest()->paginate(10);
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
            'name' => 'required|string|max:255',
        ]);

        $slug = str_slug($request->name, '-');
        $name = "";
        if ($request->featured_image) {
        	$name = time().'.' . explode('/', explode(':', substr($request->featured_image, 0, strpos($request->featured_image, ';')))[1])[1];

        	\Image::make($request->featured_image)->save(public_path('img/products/').$name);
        }
        return Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'aliexpress' => $request->aliexpress,
            'alibaba' => $request->alibaba,
            'average_selling_price' => $request->average_selling_price,
            'average_buying_price' => $request->average_buying_price,
            'slug' => $slug,
            'featured_image' => $name,
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
        return Product::find($id);
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
        $product = Product::findOrFail($id);
        $this->validate($request, [
            'name' => 'required|string|max:255',
        ]);

        $slug = str_slug($request->name, '-');
       
        if ($request->featured_image) {
        	$name = time().'.' . explode('/', explode(':', substr($request->featured_image, 0, strpos($request->featured_image, ';')))[1])[1];

        	\Image::make($request->featured_image)->save(public_path('img/products/').$name);
            $request->merge(['featured_image' => $name]);
        }
        $request->merge(['slug' => $slug]);
        $product->update($request->all());
        return ['message' => "Success"];
        /*return $product->update([
            'name' => $request['name'],
            'description' => $request->description,
            'aliexpress' => $request->aliexpress,
            'alibaba' => $request->alibaba,
            'average_selling_price' => $request->average_selling_price,
            'average_buying_price' => $request->average_buying_price,
            'slug' => $slug,
            'featured_image' => $name,
        ]);*/
    }


    public function search()
    {
        if ($search = \Request::get('q')) {
            $Products = Product::where(function($query) use ($search){
                $query->where('name', 'LIKE', "%$search%")->orWhere('email', 'LIKE', "%$search%");
            })->paginate(6);
        }
        return $Products;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Product::destroy($id);
    }
}
