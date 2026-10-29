<?php

namespace App\Exports;

use App\Models\Order;
use App\Models\Store;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SellerReportExport implements FromView
{
    protected $filters;
    protected $sellerId;

    public function __construct($sellerId, $filters = [])
    {
        $this->sellerId = $sellerId;
        $this->filters  = $filters;
    }

    public function view(): View
    {
        $query = Order::where('seller_id', $this->sellerId);

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

        $shares = Store::with('user')->where('user_id', $this->sellerId)->get();

        $grandTotal = $orders->where('status', '!=', 2)->sum('total_price');

        return view('seller.pages.report.SellerExportExcel', [
            'orders'     => $orders,
            'grandTotal' => $grandTotal,
            'shares'     => $shares,
        ]);
    }
}
