<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FaqCategory;
use App\Models\FaqItem;
use Illuminate\Http\Request;

class FaqItemAdminController extends Controller
{
    public function index()
    {
        $items = FaqItem::query()
            ->with('category')
            ->latest()
            ->paginate(15);

        return view('admin.faq_items.index', compact('items'));
    }

    public function create()
    {
        $categories = FaqCategory::query()->orderBy('name')->get();
        return view('admin.faq_items.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'faq_category_id' => ['required', 'exists:faq_categories,id'],
            'question' => ['required', 'string', 'max:255'],
            'answer' => ['required', 'string'],
        ]);

        FaqItem::create($data);

        return redirect()->route('admin.faq-items.index')->with('status', 'FAQ item created.');
    }

    public function edit(FaqItem $faq_item)
    {
        $categories = FaqCategory::query()->orderBy('name')->get();
        return view('admin.faq_items.edit', [
            'item' => $faq_item,
            'categories' => $categories,
        ]);
    }

    public function update(Request $request, FaqItem $faq_item)
    {
        $data = $request->validate([
            'faq_category_id' => ['required', 'exists:faq_categories,id'],
            'question' => ['required', 'string', 'max:255'],
            'answer' => ['required', 'string'],
        ]);

        $faq_item->update($data);

        return redirect()->route('admin.faq-items.index')->with('status', 'FAQ item updated.');
    }

    public function destroy(FaqItem $faq_item)
    {
        $faq_item->delete();

        return redirect()->route('admin.faq-items.index')->with('status', 'FAQ item deleted.');
    }
}
