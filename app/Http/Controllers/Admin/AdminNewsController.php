<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminNewsController extends Controller
{

    public function index(Request $request)
    {
        $query = News::latest();

        if ($request->filled('from_date')) {
            $query->where('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->where('created_at', '<=', $request->to_date);
        }

        $news = $query->get();

        return view('admin.pages.News.index', compact('news'));
    }

    // Store New News
    public function store(Request $request)
    {
        $request->validate([
            'title'       => 'required',
            'description' => 'required',
            'status'      => 'required',
        ]);

        $imageName = null;

        if ($request->hasFile('image')) {

            $imageName = time() . '.' . $request->image->extension();

            $request->image->move(
                public_path('uploads/news'),
                $imageName
            );
        }

        News::create([
            'title'       => $request->title,
            'description' => $request->description,
            'image'       => $imageName,
            'status'      => $request->status,
        ]);

        return redirect()->route('admin.news.index')->with('flash_success', 'News Added Successfully');
    }


    //Delete User

    public function delete($id)
    {
        $data = News::find($id);
        if ($data) {
            $data->delete();

            return redirect()->back()->with('flash_success', "News - $data->title News Deleted Successfully!");
        } else {

            return redirect()->back()->with('flash_error', "Error while deleting ID - $id");
        }
    }


    //view page
    public function view($id)
    {
        $news = News::findOrFail($id);
        return view('admin.pages.News.view', compact('news'));
    }

    //create page
    public function create()
    {
        return view('admin.pages.News.create');
    }

    //edit page
    public function edit($id)
    {
        $news = News::findOrFail($id);

        return view('admin.pages.News.edit', compact('news'));
    }

    //update page
    public function update(Request $request, $id)
    {
        $request->validate([
            'title'       => 'required',
            'description' => 'required',
            'status'      => 'required',
        ]);

        $news = News::findOrFail($id);

        $data = [
            'title'       => $request->title,
            'description' => $request->description,
            'status'      => $request->status,
        ];

        if ($request->hasFile('image')) {

            $imageName = time() . '.' . $request->image->extension();

            $request->image->move(
                public_path('uploads/news'),
                $imageName
            );

            $data['image'] = $imageName;
        }

        $news->update($data);

        return redirect()->route('admin.news.index')
            ->with('flash_success', 'News Updated Successfully');
    }

    public function export(Request $request)
    {
        $query = News::latest();

        if ($request->filled('from_date')) {
            $query->whereDate('created_at', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('created_at', '<=', $request->to_date);
        }

        $news = $query->get();

        $fileName = "news.csv";

        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
        ];

        $callback = function () use ($news) {

            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'Title',
                'Description',
                'Status',
                'Created At'
            ]);

            foreach ($news as $item) {
                fputcsv($file, [
                    $item->title,
                    $item->description,
                    $item->status,
                    $item->created_at->format('d-m-Y')
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
