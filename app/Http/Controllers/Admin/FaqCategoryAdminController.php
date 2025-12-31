<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FaqCategory;
use Illuminate\Http\Request;

class FaqCategoryAdminController extends Controller
{
    public function index()
    {
        $categories = FaqCategory::query()->orderBy('name')->paginate(15);
        return view('admin.faq_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.faq_categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:faq_categories,name'],
        ]);

        FaqCategory::create($data);

        return redirect()->route('admin.faq-categories.index')->with('status', 'FAQ category created.');
    }

    public function edit(FaqCategory $faq_category)
    {
        return view('admin.faq_categories.edit', ['category' => $faq_category]);
    }

    public function update(Request $request, FaqCategory $faq_category)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:faq_categories,name,' . $faq_category->id],
        ]);

        $faq_category->update($data);

        return redirect()->route('admin.faq-categories.index')->with('status', 'FAQ category updated.');
    }

    public function destroy(FaqCategory $faq_category)
    {
        $faq_category->delete();

        return redirect()->route('admin.faq-categories.index')->with('status', 'FAQ category deleted.');
    }
}
