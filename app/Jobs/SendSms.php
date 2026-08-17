<?php

namespace App\Jobs;

use App\Helper\SmsHelper;
use App\SMS\SmsLog;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendSms implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $customers;
    private $message;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($customers, $message)
    {
        $this->customers = $customers;
        $this->message = $message;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $sms = new SmsHelper();
        $response = $sms->bulkSms($this->customers, $this->message);

        //Save logs from response
        $response = json_decode($response,true);

        $status_code = $response['status_code'];
        $error_message = $response['error_message'];

        if($response['status_code'] == '200'){
            $smsinfo = $response['smsinfo'];

            foreach ($smsinfo as $info)
            {
                SmsLog::create([
                    'phone'         => $info['msisdn'],
                    'message'       => $this->message,
                    'status'        => $info['sms_status'],
                    'status_code'   => $status_code, // Global status code
                    'error_message' => $error_message,
                    'smsinfo'       => json_encode($info, true),
                    'created_by'    => auth()->user()->id
                ]);
            }
        } else{
            SmsLog::create([
                'phone'         => 'BULK',
                'message'       => $this->message,
                'status'        => $response['status'],
                'status_code'   => $status_code, // Global status code
                'error_message' => $error_message,
                'created_by'    => auth()->user()->id
            ]);
        }

        return $response;
    }
}
