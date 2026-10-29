<?php

namespace App\Exports;

use App\Models\Order;
use App\Models\Store;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ReportExport implements FromView
{
    protected $filters;

    public function __construct($filters = [])
    {
        $this->filters = $filters;
    }

    public function view(): View
    {
        $query = Order::query();

        if (!empty($this->filters['seller_id'])) {
            $query->where('seller_id', $this->filters['seller_id']);
        }

        if (!empty($this->filters['order_number'])) {
            $query->where('order_number', 'like', '%' . $this->filters['order_number'] . '%');
        }

        if (!empty($this->filters['month'])) {
            $query->whereMonth('order_date', $this->filters['month']);
        }

        if (!empty($this->filters['year'])) {
            $query->whereYear('order_date', $this->filters['year']);
        }

        if (isset($this->filters['status']) && $this->filters['status'] !== '') {
            $query->where('status', $this->filters['status']);
        }

        $query->where('status', '4');

        $orders = $query->latest()->get();

        $shares = $shares = Store::with('user')->get();

        $grandTotal = $orders->where('status', '!=', 2)->sum('total_price');

        return view('admin.pages.report.exportExcel', [
            'orders'     => $orders,
            'grandTotal' => $grandTotal,
            'shares'  => $shares
        ]);
    }
}
