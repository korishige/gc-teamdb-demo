<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Session;
use Input;

use App\Venue;

class VenueController extends Controller
{

  public function __construct(){
  }

  public function index(){
    $nav_on = 'top';
    $venues = Venue::paginate(20);
    return view('front.venue.index')->with(compact('nav_on','venues'));
  }

  public function show($id){
    $nav_on = 'top';
    $venue = Venue::findOrFail($id);
    return view('front.venue.show')->with(compact('nav_on','venue'));
  }

}