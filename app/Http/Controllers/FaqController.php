<?php

namespace App\Http\Controllers;

use App\Models\FaqCategory;

class FaqController extends Controller
{
    public function index()
    {
        $categories = FaqCategory::query()
            ->with('items')
            ->orderBy('name')
            ->get();

        return view('faq.index', compact('categories'));
    }
}
