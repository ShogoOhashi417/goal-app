<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;

class PersonController extends Controller
{
	public function index(Request $request)
	{
		$items = Person::all();
		return view('Person.index', ['items' => $items]);
	}
}
?>
