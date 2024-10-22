<?php

namespace App\Http\Controllers\Web\Revenues;

use App\Http\Controllers\Controller;
use App\Repositories\OrderRepository;
use PDF;

class RevenueController extends Controller
{
    private $orderRepo;
    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepo = $orderRepository;
    }

    public function index()
    {
        return view('revenues.index', [
            'revenues' => $this->orderRepo->getRevenueReportByBetweenDate(\request('from'), \request('to'))
        ]);
    }

    public function generatePDF()
    {
        if (request()->type == 'month') {
            $date = now()->format('Y, F');

        } elseif (request()->type  ==  'year') {
            $date = now()->format('Y');

        } elseif (request()->type == 'week') {
            $date = now()->subWeek()->format('Y-m-d'). "_to_".now()->format('Y-m-d');

        } else {
            $date = now()->format('Y-m-d');
        }

        $revenues = $this->orderRepo->getRevenueReport();
        $pdf = PDF::loadView('pdf.generate-revenue', [
            'revenues' => $revenues,
            'dateFilter' => $date
        ])->setPaper('a4', 'portrait');

        return $pdf->stream($date . '_incomes_' . now()->format('H-i-s') . '.pdf');
    }

    public function generateInvoicePDF()
    {
        $from = request()->from;
        $to = request()->to;

        $revenues = $this->orderRepo->getRevenueReportByBetweenDate($from,$to);
        $pdf = PDF::loadView('pdf.generate-revenue', [
            'revenues' => $revenues,
            'dateFilter' => $from .' to '. $to
        ])->setPaper('a4', 'portrait');

        return $pdf->stream($from . '_to_' . $to . '_incomes_' . now()->format('H-i-s') . '.pdf');
    }
}
