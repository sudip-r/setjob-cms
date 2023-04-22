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
     * Get jobs
     * 
     * @param Request $request
     * @return Response
     */
    public function jobs(Request $request)
    {
      $currentPage = $request->current_page ?? 1;
      $limit = $request->paginate ?? 40;
      if(isset($request->user_id))
      {
        $jobs = $this->job->paginateWithMultipleCondition(
          ['user_id' => $request->user_id, 'publish' => 1, 'trash' => 0],
          'published_on',
          'desc',
          $limit,
          ['id', 'title', 'slug', 'summary', 'user_id', 'salary_min', 'salary_max', 'published_on', 'type', 'location'],
          $currentPage
        );

        return response(['jobs' => $jobs]);
      }

      $condition = $request->condition;

      if($condition == null)
      {
        $jobs = $this->job->paginateWithMultipleCondition(
          ['publish' => 1, 'trash' => 0],
          'published_on',
          'desc',
          $limit,
          ['id', 'title', 'slug', 'summary', 'user_id', 'salary_min', 'salary_max', 'published_on', 'type', 'location'],
          $currentPage
        );

        if($jobs->count() == 0)
          return response(['jobs' => null]);
  
        return response(['jobs' => $jobs]);
      }  



      
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
