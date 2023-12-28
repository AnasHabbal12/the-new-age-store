<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CategriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if (!Gate::allows('categories.view')) { // if (!Gate::denies('categories.view')) { عكسها
            abort(403);
        }

        $request = request();

        //$query = Category::query();


        $categories = Category::with('parent')
        //LeftJoin('categories as parent', 'parent.id', '=', 'categories.parent_id')
        //->select('categories.*', 'parent.name as parent_name')
        ->filter($request->query())->orderBy("categories.name")->withCount(['products' => function($query) {
            $query->where('status', '=', 'active');
        }])
        ->paginate(); // return collection
        //$categories = Category::status('active')->paginate(10);
        return view('dashboard.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!Gate::allows('categories.create')) { // if (!Gate::denies('categories.view')) { عكسها
            abort(403);
        }
        $parents = Category::all();
        $category = new Category();
        return view('dashboard.categories.create', compact('parents', 'category'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('categories.create');
        // $request->input('name');
        // $request->post('name');
        // $request->query('name');
        // $request->get('name');
        // $request->name;
        // $request['name']
        // $request->all();
        // $request->only['name, 'img'];
        // $request->exepts['img'];
        // $category = new Category();
        // $category->name = $request->post('name');
        // $category-> save();
        // $category = new Category($request->all());
        // $category = new Category([
        //     'name' => $request->post('name'),
        //     'parent_id' => $request->post('name'),
        //     'description' => $request->post('description'),
        //     'status' => $request->post('status'),
        // ]);
        // $category-> save();

        $request->validate(Category::rules());
        // request Marge
        $request->merge(['slug' => Str::slug($request->post('name'))]);
        $data = $request->except('img');


        $data['img'] = $this -> uploadImage($request);


        $category = Category::create($data);

        // PRG : Post Redirect Get
        //return Redirect::route('categories.index');
        return redirect()->route('dashboard.categories.index')->with('success', 'Category Created !');

    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        if (!Gate::allows('categories.show')) { // if (!Gate::denies('categories.view')) { عكسها
            abort(403);
        }
        return view('dashboard.categories.show', ['category' => $category]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (!Gate::allows('categories.update')) { // if (!Gate::denies('categories.view')) { عكسها
            abort(403);
        }
        $category = Category::findOrFail($id);

        $parents = Category::where('id', '<>', $id)->where(function($query) use ($id) {
            $query->whereNull('parent_id')->orwhere('parent_id', '<>', $id);
        })->get();
        return view ('dashboard.categories.edit', compact('category', 'parents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, string $id)
    {
        //Gate::authorize('categories.update');
        $category = Category::findOrFail($id);



        $old_img = $category->img;

        $data = $request->except('img');

        $new_img = $this -> uploadImage($request);
        if ( $new_img ) {
            $data['img'] = $new_img;
        }

        $category->update( $data );

        if ($old_img && $new_img) {
            Storage::disk('public')->delete($old_img);
       }
        return redirect()->route('dashboard.categories.index')->with('success', 'Category Updated !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Gate::authorize('categories.delete');
        $category = Category::findOrFail($id);
        $category->delete();


        //Category::destroy($id);
        return redirect()->route('dashboard.categories.index')->with('success', 'Category Deleted !');
    }

    protected function uploadImage(Request $request) {

        if(!$request->hasFile('img')) {
            return;
        }
        $file = $request->file('img');
        // $file -> getClientOriginalName();
        // $file -> getSize();
        // $file -> getClientOriginalExtention();
        // $file -> getMimeType();
        $path = $file->store('uploads', ['disk' => 'public']);
        return $path;
    }

    public function trash() {
        $categories = Category::onlyTrashed()->paginate();
        return view('dashboard.categories.trash', compact('categories'));
    }

    public function restore(Request $request, $id) {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->restore();
        return redirect()->route('dashboard.categories.trash')->with('success', 'category restored!');
    }
    public function forceDelete(Request $request, $id) {
        $category = Category::onlyTrashed()->findOrFail($id);
        $category->forceDelete();
        if ($category->img) {
            Storage::disk('public')->delete($category->img);
        }
        return redirect()->route('dashboard.categories.trash')->with('success', 'category deleted!');
    }
}
