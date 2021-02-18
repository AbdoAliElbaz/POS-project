<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $q = $request->query('search');
        return view('admin.category.index', [
            'categories' => Category::with(['parent'])
                ->where('name', 'LIKE', "%{$q}%")
                ->paginate($request->query('limit', 5))
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create', [
            'categories' => Category::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $request = $this->levelHandle($request);
        return redirect(route('categories.show', Category::create($request->all())));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return view('admin.category.show',  [
            'category' => $category
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('admin.category.edit', [
            'category' => $category,
            'categories' => Category::all()

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param   CategoryRequest $request
     * @param  \App\Category  $category
     * @return void
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $request = $this->levelHandle($request);
        $category->update($request->all);
        return redirect(route('categories.show', $category));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect(route('categories.index'));
    }

    private function levelHandle($request)
    {

        if ($request->input('parent_id')) {
            $parent = Category::find($request->input('parent_id'));
            $request->merge([
                'level' => $parent->level + 1
            ]);
        }

        return $request;
    }
}
