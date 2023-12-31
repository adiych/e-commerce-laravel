<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;

class FrontendController extends Controller
{
    public $search;
    public $results;
    public function index()
    {
        $trendingProducts = Product::where('trending', '1')->latest()->take(8)->get();
        $newArrivalProducts = Product::latest()->take(8)->get();
        $featuredProducts = Product::where('featured', '1')->latest()->take(8)->get();
        return view('frontend.index', compact('trendingProducts', 'newArrivalProducts', 'featuredProducts'));
    }

    public function featuredProducts()
    {
        $featuredProducts = Product::where('featured', '1')->latest()->get();
        return view('frontend.page.featured-products', compact('featuredProducts'));
    }

    public function allProducts()
    {
        $allProducts = Product::where('status', '0')->latest()->get();
        return view('frontend.page.all-products', compact('allProducts'));
    }


    public function categories()
    {
        $categories = Category::where('status', '0')->get();
        return view('frontend.collections.category.index', compact('categories'));
    }

    public function products($category_slug)
    {
        $category = Category::where('slug', $category_slug)->first();
        if ($category) {
            return view('frontend.collections.products.index', compact('category'));
        } else {
            return redirect()->back();
        }
    }

    public function productView(string $category_slug, string $product_slug)
    {
        $category = Category::where('slug', $category_slug)->first();
        if ($category) {
            $product = $category->products()->where('slug', $product_slug)->where('status', '0')->first();
            if ($product) {
                return view('frontend.collections.products.view', compact('product', 'category'));
            } else {
                return redirect()->back();
            }
        } else {
            return redirect()->back();
        }
    }

    public function newArrival()
    {
        $newArrivalProducts = Product::latest()->take(15)->get();
        return view('frontend.page.new-arrival', compact('newArrivalProducts'));
    }

    public function thankyou()
    {
        return view('frontend.thank-you');
    }

    public function searchProducts(Request $request)
    {
        if ($request->search) {
            $searchProducts = Product::where('name', 'LIKE', '%' . $request->search . '%')->latest()->paginate(1);
            return view('frontend.page.search', compact('searchProducts'));
        } else {
            return redirect()->back()->with('message', 'Pencarian kosong');
        }
    }
}
