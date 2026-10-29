<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reminder;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class AdminReminderController extends Controller
{
    public function index(Request $request)
    {
        $query = Reminder::query();
        $userId = $request->search_user ?? 1;
        $query->where('created_by', $userId);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('reminder_type')) {
            $query->where('reminder_type', $request->reminder_type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('from_date')) {
            $query->whereDate('reminder_date', '>=', $request->from_date);
        }

        if ($request->filled('to_date')) {
            $query->whereDate('reminder_date', '<=', $request->to_date);
        }
        $reminders = $query->latest()->get();
        return view('admin.pages.Reminders.index', compact('reminders'));
    }

    public function create()
    {
        return view('admin.pages.Reminders.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'reminder_type' => 'required|in:general,bill_payment,meeting,follow_up,other',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'nullable|numeric|min:0',
            'reminder_date' => 'required|date',
            'remind_before_days' => 'required|integer|min:0',
            'repeat_type' => 'required|in:none,daily,weekly,monthly,3_months,6_months,yearly',
        ]);

        Reminder::create([
            'reminder_type' => $request->reminder_type,
            'title' => $request->title,
            'description' => $request->description,
            'amount' => $request->amount,
            'reminder_date' => $request->reminder_date,
            'remind_before_days' => $request->remind_before_days,
            'repeat_type' => $request->repeat_type,
            'status' => 'pending',
            'created_by' => Session::get('users')->id,
        ]);
        return redirect()->route('admin.reminders')->with('flash_success', 'Reminder created successfully.');
    }

    public function edit($id)
    {
        $reminder = Reminder::findOrFail($id);
        return view('admin.pages.Reminders.edit', compact('reminder'));
    }

    public function show($id)
    {
        $reminder = Reminder::findOrFail($id);

        return view('admin.pages.Reminders.show', compact('reminder'));
    }

    public function update(Request $request, $id)
    {
        $reminder = Reminder::findOrFail($id);

        $request->validate([
            'reminder_type' => 'required|in:general,bill_payment,meeting,follow_up,other',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'amount' => 'nullable|numeric|min:0',
            'reminder_date' => 'required|date',
            'remind_before_days' => 'nullable|integer|min:0',
            'repeat_type' => 'required|in:none,daily,weekly,monthly,3_months,6_months,yearly',
            'status' => 'required|in:pending,completed,cancelled',
        ]);

        $reminder->update([
            'reminder_type' => $request->reminder_type,
            'title' => $request->title,
            'description' => $request->description,
            'amount' => $request->amount,
            'reminder_date' => $request->reminder_date,
            'remind_before_days' => $request->remind_before_days,
            'repeat_type' => $request->repeat_type,
            'status' => $request->status,
        ]);
        return redirect()->route('admin.reminders')->with('flash_success', 'Reminder updated successfully.');
    }

    public function destroy($id)
    {
        $reminder = Reminder::findOrFail($id);
        $reminder->delete();
        return redirect()->route('admin.reminders')->with('flash_success', 'Reminder deleted successfully.');
    }

    public function complete($id)
    {
        $reminder = Reminder::findOrFail($id);
        if ($reminder->repeat_type === 'none') {
            $reminder->update(['status' => 'completed', 'completed_at' => now(),]);
        } else {

            $currentDate = Carbon::parse($reminder->reminder_date);

            switch ($reminder->repeat_type) {

                case 'daily':
                    $nextDate = $currentDate->copy()->addDay();
                    break;

                case 'weekly':
                    $nextDate = $currentDate->copy()->addWeek();
                    break;

                case 'monthly':
                    $nextDate = $currentDate->copy()->addMonthNoOverflow();
                    break;

                case '3_months':
                    $nextDate = $currentDate->copy()->addMonthsNoOverflow(3);
                    break;
 
                case '6_months':
                    $nextDate = $currentDate->copy()->addMonthsNoOverflow(6);
                    break;

                case 'yearly':
                    $nextDate = $currentDate->copy()->addYearNoOverflow();
                    break;

                default:
                    $nextDate = $currentDate;
                    break;
            }

            $reminder->update(['reminder_date' => $nextDate->format('Y-m-d'), 'status' => 'pending', 'completed_at' => null,]);
        }

        return redirect()->back()->with('flash_success', 'Reminder completed successfully.');
    }

    public function status($id)
    {
        $reminder = Reminder::findOrFail($id);
        $reminder->update(['status' => $reminder->status === 'cancelled' ? 'pending' : 'cancelled',]);
        return redirect()->back()->with('flash_success', 'Reminder status updated successfully.');
    }
}
