<?php

namespace App\Http\Controllers\alterCMS\Page;

use App\AlterBase\Models\Page\Page;
use App\AlterBase\Repositories\Page\PageRepository;
use App\Http\Requests\PageRequest;
use App\AlterBase\Repositories\Media\MediaRepository;
use App\AlterBase\Repositories\Category\CategoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\DatabaseManager;
use Illuminate\View\View;
use Psr\Log\LoggerInterface;

class PageController extends Controller
{
  /**
   * PageRepository $page
   */
  private $page;

  /**
   * MediaRepository $media
   */
  private $media;

  /**
   * CategoryRepository $category
   */
  private $category;

  /**
   * @var DatabaseManager
   */
  private $db;

  /**
   * @var LoggerInterface
   */
  private $log;

  /**
   * PageController constructor.
   * @param PageRepository $page
   * @param MediaRepository $media
   * @param DatabaseManager $db
   * @param LoggerInterface $log
   */
  public function __construct(
    PageRepository $page,
    MediaRepository $media,
    DatabaseManager $db,
    LoggerInterface $log
  ) {
    $this->page     = $page;
    $this->media    = $media;
    $this->db       = $db;
    $this->log      = $log;
  }

  /**
   * Show all page
   *
   * @return View
   */
  public function index()
  {
    $this->authorize('view', Page::class);
    $pages = $this->page->paginate();

    return view('cms.page.index')
      ->with('pages', $pages);
  }

  /**
   * Search page
   *
   * @param Request $request
   * @return View
   */
  public function search(Request $request)
  {
    $this->authorize('view', Page::class);
    $pages = $this->page->searchPage([], $request->search_txt, "id", "desc", ['*'], 40);

    return view('cms.page.index')
      ->with('pages', $pages)
      ->with("searchTxt", $request->search_txt);
  }

  /**
   * Show form to create new page
   *
   * @return View
   */
  public function create()
  {
    abort(404);
    // $this->authorize('create', Page::class);

    // $medias = $this->media->paginate(40, "created_at");

    // return view('cms.page.create')
    //   ->with('lastPage', $medias->lastPage());
  }

  /**
   * Store newly created page
   *
   * @param PageRequest $request
   * @return $this|\Illuminate\Http\RedirectResponse
   */
  public function store(PageRequest $request)
  {
    $this->authorize('create', Page::class);
    try {
      $this->db->beginTransaction();

      $input = $request->only([
        'page', 'summary', 'description', 'type', 'blocks', 'image', 'video', 'cover'
      ]);

      $input['slug'] = strtolower(str_replace(" ", "-",$input['page']))."-".date("Ymdhis");

      $input['publish'] = 0;

      if (isset($request->publish))
        $input['publish'] = 1;

      $page = $this->page->store($input);

      $this->db->commit();

      return redirect()->route('cms::pages.index')
        ->with('success', "Page added successfully.")
        ->with('page', $page->id);
    } catch (\Exception $e) {
      $this->db->rollback();
      $this->log->error((string)$e);

      return redirect()->route('cms::pages.create')
        ->with('error', "Failed to add page. " . $e->getMessage())
        ->withInput();
    }
  }

  /**
   * Show form to edit page
   *
   * @param Page $page
   * @return View
   */
  public function edit(Page $page)
  {
    $this->authorize('update', Page::class);

    $medias = $this->media->paginate(40, "created_at");

    return view('cms.page.edit')
      ->with('page', $page)
      ->with('lastPage', $medias->lastPage());
  }

  /**
   * Update page
   *
   * @param PageRequest $request
   * @param $id
   * @return \Illuminate\Http\RedirectResponse
   */
  public function update(PageRequest $request, $id)
  {
    $this->authorize('update', Page::class);
    $page = $this->page->find($id);

    try {
      $this->db->beginTransaction();

      $input = $request->only([
          'page', 'summary', 'description', 'type', 'blocks', 'image', 'video', 'cover'
      ]);

      $input['publish'] = 0;

      if (isset($request->publish))
        $input['publish'] = 1;

      $this->page->update($id, $input);
      $this->db->commit();

      return redirect()->route('cms::pages.index')
        ->with('success', 'Page updated successfully.')
        ->with('page', $page->id);
    } catch (\Exception $e) {
      $this->db->rollback();
      $this->log->error((string)$e);

      return redirect()->route('cms::pages.edit', ['page' => $id])
        ->with('error', 'Failed to update page. ' . $e->getMessage())
        ->withInput();
    }
  }

  /**
   * Delete given page
   *
   * @param Page $page
   * @return string
   */
  public function delete(Page $page)
  {
    $this->authorize('delete', Page::class);

    try {
      $this->db->beginTransaction();
      $this->page->delete($page->id);

      $this->db->commit();
      return redirect()->route('cms::pages.index')
        ->with('success', 'Page deleted successfully.');
    } catch (\Exception $e) {
      $this->db->rollback();
      $this->log->error((string)$e);

      return redirect()->route('cms::pages.index')
        ->with('error', 'Failed to delete page.')
        ->withInput();
    }
  }

}
