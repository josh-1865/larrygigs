<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ListingController extends Controller
{
    public function index()
    {
        $filters = [
            'tag' => request('tag'),
            'search' => request('search')
        ];

        return view('listings.index', [
            'listings' => Listing::latest()->filter($filters)->paginate(4),
        ]);
    }
    public function show($id)
    {
        $jobs = Listing::find($id);
        if ($jobs) {
            return view('listings.show', [
                'jobs' => $jobs
            ]);
        } else {
            abort(404);
        }
    }
    //show create form
    public function create()
    {
        return view('listings.create');
    }

    //store listing
    public function store(Request $request)
    {
        $formFields = $request->validate([
            'title' => 'required',
            'company' => 'required',
            'location' => 'required',
            'email' => 'required|email',
            'website' => 'required',
            'tags' => 'required',
            'description' => 'required'

        ]);
        //handle file upload
        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }
        //add user id to form
        $formFields['user_id'] = Auth::id();

        //create listing
        Listing::create($formFields);



        return redirect('/')->with('message', 'Listing created successfully!');
    }

    //edit listing
    public function edit($id)
    {
        $jobs = Listing::find($id);
        if ($jobs) {
            return view('listings.edit', [
                'jobs' => $jobs
            ]);
        } else {
            abort(404);
        }
    }
    //update listing
    public function update(Request $request, $id)
    {
        //make sure login user is owner
        $listing = Listing::find($id);
        if (!$listing || $listing->user_id != Auth::id()) {
            abort(403, 'unauthorized action');
        }
        $formFields = $request->validate([
            'title' => 'required',
            'company' => 'required',
            'location' => 'required',
            'email' => 'required|email',
            'website' => 'required',
            'tags' => 'required',
            'description' => 'required'

        ]);
        //handle file upload
        if ($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }
        //update listing
        Listing::find($id)->update($formFields);

        return redirect('/')->with('message', 'Listing updated successfully!');
    }
    //delete listing
    public function destroy($id)
    {
        //make sure login user is owner
        $listing = Listing::find($id);
        if (!$listing || $listing->user_id != Auth::id()) {
            abort(403, 'unauthorized action');
        }
        //delete listing
        Listing::find($id)->delete();
        return redirect('/')->with('message', 'Listing deleted successfully!');
    }
    //manage listings
    public function manage()
    {
        return view('listings.manage', [
            'listings' => Listing::where('user_id', Auth::id())->latest()->paginate(4)
        ]);
    }
}
