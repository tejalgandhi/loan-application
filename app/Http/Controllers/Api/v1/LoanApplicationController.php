<?php

namespace App\Http\Controllers\Api\v1;

use App\Helper\Helper;
use App\Http\Controllers\Controller;
use App\Models\LoanApplication;
use App\Models\Status;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
class LoanApplicationController extends Controller
{
    /*
         *
         * create loan application
         */
    public function postLoanApplication(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => 'required',
                'loan_amount' => 'required|numeric',
                'description' => 'required',
                'loan_months' => 'required|integer',
            ], [
                'loan_amount.required' => "Amount is Required",
                'description.required' => "Description is Required",
            ]);
            if ($validator->fails()) {
                return Helper::returnresponse(401,$validator->messages()->first(),[]);
            }

            LoanApplication::create([
                'user_id'=>$request->user_id,
                'loan_amount'=>$request->loan_amount,
                'description'=>$request->description,
                'loan_months'=>$request->loan_months,
            ]);
            return Helper::returnresponse(200,'Loan application created successfully',[]);

        } catch (\Exception $e) {
            return Helper::returnResponse(500,$e->getMessage(),[]);
        }
    }
    /*
     *
     * change application status
     */
    public function changeApplicationStatus(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'application_id'=>'required',
                'status'=>'required',
            ],[
                'application_id.required' => "Application id is Required",
                'status.required' => "Status is Required",
            ]);
            if ($validator->fails()) {
                return Helper::returnresponse(401,$validator->messages()->first(),[]);
            }
            $loan =  LoanApplication::where('id',$request->application_id)->whereIn('status_id',[
                Status::PROCESSING_STATUS, Status::NEW_STATUS
            ])->first();
            if(empty($loan)){
                return Helper::returnResponse(500,'Loan application does not exist',[]);
            }

            if($request->status == Status::APPROVED_STATUS){
               $amount =  $this->calculatePayments($loan->loan_amount,$loan->loan_months);
                LoanApplication::where('id',$request->application_id)->update(['loan_amount_pay_for_month_week'=>$amount]);
            }

            LoanApplication::where('id',$request->application_id)->update([
                'status_id'=>$request->status
            ]);

            return Helper::returnresponse(200,'Loan application status successfully updated.',[]);
        } catch (\Exception $e) {
            return Helper::returnResponse(500,$e->getMessage(),[]);
        }
    }

    /*
     * calculate application to monthly to weekly
     */

    public function changeWeeklyPayment(Request $request){
        try {
            $validator = Validator::make($request->all(), [
                'application_id'=>'required',
            ],[
                'application_id.required' => "Application id is Required",
            ]);
            if ($validator->fails()) {
                return Helper::returnresponse(401,$validator->messages()->first(),[]);
            }
            $loan =  LoanApplication::where('id',$request->application_id)
                ->where('status_id',Status::APPROVED_STATUS)->first();
            if(empty($loan)){
                return Helper::returnResponse(500,'Loan application does not approved yet.',[]);
            }
            $amount =  $this->calculatePayments($loan->loan_amount,$loan->loan_months,0);
            LoanApplication::where('id',$request->application_id)
                ->update(['loan_amount_pay_for_month_week'=>$amount,'loan_term'=>LoanApplication::WEEKLY_LOAN]);


            return Helper::returnresponse(200,'Weekly Repayment successfully stored.',[]);
        } catch (\Exception $e) {
            return Helper::returnResponse(500,$e->getMessage(),[]);
        }
    }

    /*
     * calculate the payment of loan monthly and weekly
     */
    function calculatePayments($fLoanAmount , $iTerm ,$month= 1 ,$fAPR=5 )
    {
        if($month) {
            return ($fLoanAmount/$iTerm)+(($fLoanAmount/$iTerm)/100*($fAPR / 12 * $iTerm));
        }else{
            return (($fLoanAmount/$iTerm)+(($fLoanAmount/$iTerm)/100*($fAPR / 12 * $iTerm)))/4;
        }
    }



}