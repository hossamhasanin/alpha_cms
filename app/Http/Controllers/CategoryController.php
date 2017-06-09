<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Categories;

class CategoryController extends Controller
{
    public function AddNew_form()
    {
    	$parents = Categories::where("parent" , 0)->get();
    	return view("blades.AddCategory" , ["parents" , $parents]);
    }

    public function AddNew(Request $request)
    {
    	$this->validate($request , [
    		"cat_name" => "required",
    		"cat_slug" => "required|unique:categories",
    		"parent" => "integer",
    		"description" => "required|alpha_num",
    		"icon" => "alpha_dash"
    	]);

    	$new_cat = new Categories();
    	$new_cat->cat_name = $request->cat_name;
    	$new_cat->cat_slug = $request->cat_slug;
    	$new_cat->parent = isset($request->parent) ? $request->parent : 0;
    	$new_cat->description = $request->description;
    	$new_cat->icon = $request->icon;
    	$new_cat->save();

    	$request->session()->flash("cat_success" , "You added category successfully!");
    	return redirect()->route("all_cats");

    }


    public function AllCats()
    {
    	$cats = Categories::get();

    	return view("blades.AllCategories" , ["cats" => $cats]);
    }



}
