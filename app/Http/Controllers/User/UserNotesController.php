<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Notes;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class UserNotesController extends Controller
{
    // List
    public function index(Request $request)
    {
        $query = Notes::where('user_id', Session::get('users')->id);

        if ($request->filled('from_date')) {
            $query->whereDate('reminder_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('reminder_date', '<=', $request->to_date);
        }

        $notes = $query->latest()->get();

        return view('user.pages.Notes.index', compact('notes'));
    }

    // Add Form
    public function create()
    {
        return view('user.pages.Notes.create');
    }

    // Save Note
    public function store(Request $request)
    {
       
        $request->validate([
            'title'           => 'required|max:255',
            'description'     => 'required',
            'category'        => 'nullable|max:255',
            'priority'        => 'required|in:Low,Medium,High',
            'reminder_date'   => 'nullable|date',
            'status'          => 'required|in:Active,Archived',
            'attachment'      => 'nullable|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        $fileName = null;

        if ($request->hasFile('attachment')) {

            $fileName = time() . '.' . $request->attachment->extension();

            $request->attachment->move(public_path('uploads/notes'), $fileName);
        }

        Notes::create([
            'user_id'         => Session::get('users')->id,
            'title'           => $request->title,
            'description'     => $request->description,
            'category'        => $request->category,
            'priority'        => $request->priority,
            'reminder_date'   => $request->reminder_date,
            'status'          => $request->status,
            'attachment'      => $fileName,
        ]);

        return redirect()->route('user.notes.index')->with('flash_success', 'Note added successfully.');
    }

    // Edit Form
    public function edit($id)
    {
        $note = Notes::where('user_id', Session::get('users')->id)->findOrFail($id);

        return view('user.pages.Notes.edit', compact('note'));
    }

    // Update Note
    public function update(Request $request, $id)
    {
        $note = Notes::where('user_id', Session::get('users')->id)->findOrFail($id);

        $request->validate([
            'title'           => 'required|max:255',
            'description'     => 'required',
            'category'        => 'nullable|max:255',
            'priority'        => 'required|in:Low,Medium,High',
            'reminder_date'   => 'nullable|date',
            'status'          => 'required|in:Active,Archived',
            'attachment'      => 'nullable|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        $fileName = $note->attachment;

        if ($request->hasFile('attachment')) {

            $fileName = time() . '.' . $request->attachment->extension();

            $request->attachment->move(public_path('uploads/notes'), $fileName);
        }

        $note->update([
            'title'           => $request->title,
            'description'     => $request->description,
            'category'        => $request->category,
            'priority'        => $request->priority,
            'reminder_date'   => $request->reminder_date,
            'status'          => $request->status,
            'attachment'      => $fileName,
        ]);

        return redirect()->route('user.notes.index')->with('flash_success', 'Note updated successfully.');
    }

    // Delete
    public function destroy($id)
    {
        $note = Notes::where('user_id', Session::get('users')->id)->findOrFail($id);

        if ($note->attachment && file_exists(public_path('uploads/notes/' . $note->attachment))) {
            unlink(public_path('uploads/notes/' . $note->attachment));
        }

        $note->delete();

        return redirect()->route('user.notes.index') ->with('flash_success', 'Note deleted successfully.');
    }

    // Show Single Note
    public function show($id)
    {
       $note = Notes::findOrFail($id);

    return view('user.pages.Notes.show', compact('note'));
    }
}
