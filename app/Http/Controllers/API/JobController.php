<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\AlterBase\Repositories\Job\JobRepository;
use Illuminate\Http\Request;

class JobController extends Controller
{
    /**
     * JobRepository $job
     */
    private $job;

    /**
     * JobController Constructor
     * 
     * @param JobRepository $job
     */
    public function __construct(JobRepository $job)
    {
        $this->job = $job;
    }

    /**
     * Toggle jobs status
     * 
     * @param Request $request
     * @return Response
     */
    public function toggleJobStatus(Request $request)
    {   
       $id = $request->id;

       try{
        $job = $this->job->find($id);

        if ($job->publish)
         $input['publish'] = 0;
        else 
         $input['publish'] = 1;
 
         $this->job->update($job->id, $input);

         return response(['success' => '1', 'message' => 'Job status updated!']);
       }catch(\Exception $e){
         return response(['success' => '0', 'message' => 'Something went wrong']);
       }
       
    }
}
