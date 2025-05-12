<?php

namespace App\Http\Controllers;

use App\Models\AluminiQuery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QueryController extends Controller
{
    //
    public function index()
    {
        $queries = AluminiQuery::where('user_id', Auth::id())->latest()->get();
        return view('alumini.queries.queries', compact('queries'));
    }
    public function create()
    {
        return view("alumini.queries.addQueries");
    }
    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'query' => 'required|string|max:1000',
        ]);

        AluminiQuery::create([
            'user_id' => Auth::id(),
            'subject' => $request->input('subject'),
            'query' => $request->input('query'),
        ]);

        return redirect()->route('alunimi.query')->with('success', 'Query submitted successfully.');
    }
    public function adminIndex()
    {
        $queries = AluminiQuery::with('user')->latest()->get();
        return view('Admin.aluminiQueries.queries', compact('queries'));
    }

    public function adminShow($id)
    {
        $query = AluminiQuery::with('user')->findOrFail($id);
        return view('admin.aluminiQueries.reply', compact('query'));
    }
    public function reply(Request $request, $id)
    {
        $request->validate([
            'adminReply' => 'required|string'
        ]);

        $query = AluminiQuery::findOrFail($id);
        $query->adminReply = $request->adminReply;
        $query->save();

        return redirect()->route('admin.queries.index')->with('success', 'Reply sent successfully.');
    }
}