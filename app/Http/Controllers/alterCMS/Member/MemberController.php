<?php

namespace App\Http\Controllers\alterCMS\Member;

use App\AlterBase\Models\Member\Member;
use App\AlterBase\Repositories\Member\MemberRepository;
use App\Http\Controllers\Controller;
use Illuminate\Database\DatabaseManager;
use Psr\Log\LoggerInterface;
use Illuminate\Http\Request;

/**
 * Class UserController
 * @package App\Http\Controllers\CMS
 */
class MemberController extends Controller
{
    /**
     * @var MemberRepository
     */
    private $member;
    /**
     * @var LoggerInterface
     */
    private $log;
    /**
     * @var DatabaseManager
     */
    private $db;

    /**
     * MemberController constructor.
     * @param MemberRepository $member
     * @param LoggerInterface $log
     * @param DatabaseManager $db
     */
    public function __construct(
        MemberRepository $member, 
        LoggerInterface $log, 
        DatabaseManager $db)
    {
        $this->member = $member;
        $this->log = $log;
        $this->db = $db;
    }

    /**
     * Show all the employees
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function employee()
    {
        $this->authorize('employee', Member::class);

        $members = $this->member->paginateWithCondition('guard', 'client', 'id', 'desc', 50);
        
        return view('cms.members.employee')
            ->with('members', $members);
    }

    /**
     * Search from all the employees
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function employeeSearch(Request $request)
    {
        $this->authorize('employee', Member::class);

        $members = $this->member->searchMembers(['guard' => 'client'], $request->search_txt);

        return view('cms.members.employee')
            ->with('members', $members)
            ->with("searchTxt", $request->search_txt);
    }

    /**
     * Show all the employers
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function employer()
    {
        $this->authorize('employer', Member::class);

        $members = $this->member->paginateWithCondition('guard', 'business', 'id', 'desc', 50);

        return view('cms.members.employer')
            ->with('members', $members);
    }

    /**
     * Search from all the employees
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function employerSearch(Request $request)
    {
        $this->authorize('employee', Member::class);

        $members = $this->member->searchMembers(['guard' => 'business'], $request->search_txt);

        return view('cms.members.employer')
            ->with('members', $members)
            ->with("searchTxt", $request->search_txt);
    }

  /**
   * Ban / Unban members
   *
   * @param $member
   * @return \Illuminate\Http\RedirectResponse
   */
  public function toggleStatus(Member $member)
  {
    try {
      $this->db->beginTransaction();

      if ($member->active){
        $input['active'] = 0;
        $message = $member->name . " is now deactivated and cannot login to their dashboard!";
      }
      else {
        $input['active'] = 1;
        $message = $member->name . " is now activated and will be able to login to their dashboard!";

      }

      $this->member->update($member->id, $input);
      $this->db->commit();

      $route = "employer";
      if($member->guard == "client")
        $route = "employee";

      return redirect()->route('cms::members.'.$route)
        ->with('success', $message);

    } catch (\Exception $e) {
      $this->db->rollback();
      $this->log->error((string)$e);
      $route = "employer";
      if($member->guard == "client")
        $route = "employee";
      return redirect()->route('cms::members.'.$route)
        ->with('error', 'Filed to update status. ' . $e->getMessage())
        ->withInput();
    }
  }
   
}
