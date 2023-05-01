<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\AlterBase\Repositories\Job\JobRepository;
use App\AlterBase\Repositories\User\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobController extends Controller
{
    /**
     * JobRepository $job
     */
    private $job;

    /**
     * UserRepository $user
     */
    private $user;

    /**
     * JobController Constructor
     * 
     * @param JobRepository $job
     * @param UserRepository $user
     */
    public function __construct(JobRepository $job, UserRepository $user)
    {
        $this->job = $job;
        $this->user = $user;
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
          ['id', 'title', 'slug', 'summary', 'user_id', 'salary_min', 'salary_max', 'published_on', 'type', 'location', 'category_id'],
          $currentPage
        );

        return response(['jobs' => $jobs]);
      }

      $search = $request->search ?? "";

      $condition = $request->conditions;

      if($condition == null)
      {
        $jobs = $this->job->paginateWithSearch(
          ['publish' => 1, 'trash' => 0],
          $search,
          'published_on',
          'desc',
          $limit,
          ['id', 'title', 'slug', 'summary', 'user_id', 'salary_min', 'salary_max', 'published_on', 'type', 'location', 'category_id'],
          $currentPage
        );

        if($jobs->count() == 0)
          return response(['jobs' => null]);
  
        return response(['jobs' => $jobs, 'conditions' => $condition]);
      }  

      // DB::enableQueryLog();
        $jobs = $this->job->paginateWithFilters(
          $condition,
          ['publish' => 1, 'trash' => 0],
          $search,
          'published_on',
          'desc',
          $limit,
          ['id', 'title', 'slug', 'summary', 'user_id', 'salary_min', 'salary_max', 'published_on', 'type', 'location', 'category_id'],
          $currentPage
        );

        // $query = $jobs->toSql();
                
        // $bindings =$jobs->getBindings();
                
        // // Combine the SQL query and bindings into a single string
        // $sql = vsprintf(str_replace('?', '%s', $query), $bindings);

        if($jobs->paginate($limit, null, 'page', $currentPage)->count() == 0)
          return response(['jobs' => null]);
  
        return response(['jobs' => $jobs->paginate($limit, null, 'page', $currentPage)]);

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

    /**
     * Get users by conditions
     * 
     * @param Request $request
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    public function userList(Request $request)
    {
      $str = $request->q;

      $employers = $this->user->searchUsers(['guard' => 'business'], $str, 'name', 'asc', ['id', 'name']);

      return response(['users' => $employers->toArray()]);
    }
}
