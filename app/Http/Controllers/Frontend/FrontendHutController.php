<?php

namespace App\Http\Controllers\Frontend;

use Carbon\Carbon;
use App\Models\Hut;
use App\Models\Facility;
use Carbon\CarbonPeriod;
use App\Models\MultiImage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\HutBookedDate;

class FrontendHutController extends Controller
{
    public function AllFrontendHutList()
    {
        $huts = Hut::latest()->get();
        return view('frontend.hut.all_huts', compact('huts'));
    }

    public function HutDetailsPage($id)
    {
        $hutdetails = Hut::find($id);
        $multiImage = MultiImage::where('huts_id', $id)->get();
        $facility = Facility::where('huts_id', $id)->get();
        $otherHuts = Hut::where('id', '!=', $id)->orderBy('id', 'DESC')->limit(2)->get();
        return view('frontend.hut.hut_details', compact('hutdetails', 'multiImage', 'facility', 'otherHuts'));
    }

    public function BookingSearch(Request $request)
    {
        $request->flash();
        if ($request->check_in == $request->check_out) {
            $notification = array(
                'message' => 'Somthing want to wrong',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
        if ($request->check_out < $request->check_in) {
            $notification = array(
                'message' => 'Check-out date cannot be before check-in date.',
                'alert-type' => 'error'
            );
            return redirect()->back()->with($notification);
        }
        $sdate = date('Y-m-d', strtotime($request->check_in));
        $edate = date('Y-m-d', strtotime($request->check_out));
        $alldate = Carbon::create($edate)->subDay();
        $d_period = CarbonPeriod::create($sdate, $alldate);
        $dt_array = [];
        foreach ($d_period as $period) {
            array_push($dt_array, date('Y-m-d', strtotime($period)));
        }

        $check_date_booking_ids = HutBookedDate::whereIn('book_date', $dt_array)->distinct()->pluck('booking_id')->toArray();

        $huts = Hut::withCount('hut_numbers')->where('status', 1)->get();

        return view('frontend.hut.search_hut', compact('huts', 'check_date_booking_ids'));
    }

    public function SearchHutDetails(Request $request, $id)
    {
        $request->flash();
        $hutdetails = Hut::find($id);
        $multiImage = MultiImage::where('huts_id', $id)->get();
        $facility = Facility::where('huts_id', $id)->get();
        $otherHuts = Hut::where('id', '!=', $id)->orderBy('id', 'DESC')->limit(2)->get();
        $hut_id = $id;
        return view('frontend.hut.search_hut_details', compact('hutdetails', 'multiImage', 'facility', 'otherHuts', 'hut_id'));
    }

    public function ChekHutAvailability(Request $request)
    {
        $sdate = date('Y-m-d', strtotime($request->check_in));
        $edate = date('Y-m-d', strtotime($request->check_out));
        $alldate = Carbon::create($edate)->subDay();
        $d_period = CarbonPeriod::create($sdate, $alldate);
        $dt_array = [];
        foreach ($d_period as $period) {
            array_push($dt_array, date('Y-m-d', strtotime($period)));
        }

        $check_date_booking_ids = HutBookedDate::whereIn('book_date', $dt_array)->distinct()->pluck('booking_id')->toArray();

        $hut = Hut::withCount('hut_numbers')->find($request->hut_id);
        $bookings = Booking::withCount('assign_huts')->whereIn('id', $check_date_booking_ids)->where('huts_id', $hut->id)->get()->toArray();
        $total_book_hut = array_sum(array_column($bookings, 'assign_huts_count'));
        $av_hut = @$hut->hut_numbers_count - $total_book_hut;
        $fromDate = Carbon::parse($request->check_in);
        $toDate = Carbon::parse($request->check_out);
        $nights = $toDate->diffInDays($fromDate);
        return response()->json(['available_hut' => $av_hut, 'total_nights' => $nights]);
    }
}
