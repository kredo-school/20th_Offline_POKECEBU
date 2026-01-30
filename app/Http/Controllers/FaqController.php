<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\FaqCategory;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    private $category;
    private $faq;

    public function __construct(FaqCategory $category, Faq $faq) {
        $this->category = $category;
        $this->faq = $faq;    
    }

    public function index()
    {
        $all_categories = $this->category->with('faqs')->orderBy('soft_order')->get();
        $first_category = $all_categories->first();
        return view('adminpage.faqs.faq', compact('all_categories', 'first_category'));
    }

    public function displayList() {
        $all_categories = $this->category->all();
        $all_faqs = $this->faq->with('category')->withTrashed()
                        ->orderBy('faq_category_id')
                        ->orderBy('soft_order')
                        ->get();
        return view('adminpage.faqs.faq-list', compact('all_categories', 'all_faqs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category' => 'required',
            'title' => 'required|max:255',
            'question' => 'required',
            'answer' => 'required',
            'order_no' => 'required'
        ]);

        $this->faq->faq_category_id = $request->category;
        $this->faq->title = $request->title;
        $this->faq->question = $request->question;
        $this->faq->answer = $request->answer;
        $this->faq->soft_order = $request->order_no;

        $this->faq->save();

        return redirect()->route('faq.displayList');
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'category' => 'required',
            'title' => 'required|max:255',
            'question' => 'required',
            'answer' => 'required',
            'order_no' => 'required'
        ]);

        $faq = $this->faq->withTrashed()->findOrFail($id);

        $faq->faq_category_id = $request->category;
        $faq->title = $request->title;
        $faq->question = $request->question;
        $faq->answer = $request->answer;
        $faq->soft_order = $request->order_no;

        $faq->save();

        return redirect()->back();
    }

    public function destroy(string $id)
    {
        $faq = $this->faq->withTrashed()->findOrFail($id);
        
        $faq->forceDelete();

        return redirect()->back();
    }

    public function hidden($id) {
        $this->faq->destroy($id);
        
        return redirect()->back();
    }

    public function visible($id) {
        $this->faq->onlyTrashed()->findOrFail($id)->restore();
        return redirect()->back();
    }

    public function storeCategory(Request $request) {
        $request->validate([
            'category' => 'required',
            'order_no' => 'required'
        ]);

        $this->category->name = $request->category;
        $this->category->soft_order = $request->order_no;

        $this->category->save();

        return redirect()->route('faq.displayList');
    }
}
