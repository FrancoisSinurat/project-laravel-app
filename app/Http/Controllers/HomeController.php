<?php

namespace App\Http\Controllers;

use App\Models\ItemCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $cards = ItemCategory::query()
            ->leftJoin('assets', 'assets.item_category_id', '=', 'item_categories.item_category_id')
            ->select('item_categories.item_category_id as item_category_id', 'item_categories.item_category_name as category_name', 'item_categories.item_category_icon as category_icon', 'item_categories.item_category_color as category_color', 'item_categories.item_category_text as category_text', 'item_categories.item_category_color_bg as category_colorBg', DB::raw('COUNT(assets.item_category_id) as count'))
            ->groupBy('item_categories.item_category_id', 'item_categories.item_category_name')
            ->orderBy('item_categories.item_category_name', 'ASC')
            ->get();

            $chartLabel = $cards->pluck('category_name');
            $chartColor = $cards->pluck('category_colorBg');
            $chartData = $cards->pluck('count');

            return view('dashboard', compact('cards', 'chartData','chartLabel','chartColor'));
    }
}
