<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Models\Leave;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LeaveController extends Controller
{
    public function applyLeaveStore(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date_from'  => 'required|date|before_or_equal:date_to',
            'date_to'    => 'required|date|after_or_equal:date_from',
            'reason'     => 'required|string|max:5000',
            'leave_type' => 'required|string|max:50',
            'submitted_by' => 'required|string|max:50',
            //'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error('Validation failed', $validator->errors(), 422);
        }


        /*$attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('attachments', 'public');
        }*/

        $financialYear = $this->getFinancialYear();

        // Find the latest serial in this FY
        $lastSerial = Leave::where('leave_application_id', 'like', "NRDS-LV-{$financialYear}-%")
            ->selectRaw("MAX(CAST(SUBSTRING_INDEX(leave_application_id, '-', -1) AS UNSIGNED)) as max_serial")
            ->value('max_serial');

        $nextSerial = $lastSerial ? $lastSerial + 1 : 1;
        $serial = str_pad($nextSerial, 3, '0', STR_PAD_LEFT);

        $leaveApplicationId = "NRDS-LV-{$financialYear}-{$serial}";

        $leave = Leave::create([
            'leave_application_id' => $leaveApplicationId,
            'date_from'            => $request->date_from,
            'date_to'              => $request->date_to,
            'reason'               => $request->reason,
            'leave_type'           => $request->leave_type,
            //'attachment'           => $attachmentPath,
            'submitted_by'         => $request->submitted_by,
            'submitted_on'         => now(),
            'is_deleted'           => false,
            'is_approved'          => false,
        ]);

        return ApiResponse::success(200, 'Leave Applied Successfully', "leave", $leave);

    }
    function getFinancialYear()
    {
        $year = now()->year;
        $month = now()->month;

        // Financial year in India is Apr-Mar
        if ($month < 4) {
            // Before April → previous year as start
            $start = $year - 1;
            $end   = $year;
        } else {
            $start = $year;
            $end   = $year + 1;
        }

        // Take last 2 digits
        return substr($start, -2) . substr($end, -2); // e.g. 2526
    }

    public function viewLeave($id)
    {
        // Fetch leave by ID
        $leave = Leave::find($id);

        return ApiResponse::success(200, 'Fetched Leave', "leave", $leave);
    }
    public function myLeaves(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|string|max:50',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error('Validation failed', $validator->errors(), 422);
        }

        $query = Leave::where('submitted_by', $request->user_id);

        $leaves = $query->orderBy('submitted_on', 'desc')->get();
        return ApiResponse::success(200, 'Fetched Leave', "leaves", $leaves);

    }

}
