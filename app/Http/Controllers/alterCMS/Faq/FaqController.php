<?php

namespace App\Http\Controllers\alterCMS\Faq;

use App\AlterBase\Models\Faq\Faq;
use App\AlterBase\Repositories\Faq\FaqRepository;
use App\Http\Requests\FaqRequest;
use App\AlterBase\Repositories\Media\MediaRepository;
use App\AlterBase\Repositories\Category\CategoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\DatabaseManager;
use Illuminate\View\View;
use Psr\Log\LoggerInterface;

class FaqController extends Controller
{
  /**
   * FaqRepository $faq
   */
  private $faq;

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
   * FaqController constructor.
   * @param FaqRepository $faq
   * @param MediaRepository $media
   * @param DatabaseManager $db
   * @param LoggerInterface $log
   */
  public function __construct(
    FaqRepository $faq,
    MediaRepository $media,
    DatabaseManager $db,
    LoggerInterface $log
  ) {
    $this->faq     = $faq;
    $this->media    = $media;
    $this->db       = $db;
    $this->log      = $log;
  }

  /**
   * Show all faq
   *
   * @return View
   */
  public function index()
  {
    $this->authorize('view', Faq::class);
    $faqs = $this->faq->paginate();

    return view('cms.faq.index')
      ->with('faqs', $faqs);
  }

  /**
   * Search faq
   *
   * @param Request $request
   * @return View
   */
  public function search(Request $request)
  {
    $this->authorize('view', Faq::class);
    $faqs = $this->faq->searchFaq([], $request->search_txt, "id", "desc", ['*'], 40);

    return view('cms.faq.index')
      ->with('faqs', $faqs)
      ->with("searchTxt", $request->search_txt);
  }

  /**
   * Show form to create new faq
   *
   * @return View
   */
  public function create()
  {
    $this->authorize('create', Faq::class);

    $medias = $this->media->paginate(40, "created_at");

    return view('cms.faq.create')
      ->with('lastPage', $medias->lastPage());
  }

  /**
   * Store newly created faq
   *
   * @param FaqRequest $request
   * @return $this|\Illuminate\Http\RedirectResponse
   */
  public function store(FaqRequest $request)
  {
    $this->authorize('create', Faq::class);
    try {
      $this->db->beginTransaction();

      $input = $request->only([
        'question', 'answer', 'sort_order'
      ]);

      $input['publish'] = 0;

      if (isset($request->publish))
        $input['publish'] = 1;

      $faq = $this->faq->store($input);

      $this->db->commit();

      return redirect()->route('cms::faqs.index')
        ->with('success', "Faq added successfully.")
        ->with('faq', $faq->id);
    } catch (\Exception $e) {
      $this->db->rollback();
      $this->log->error((string)$e);

      return redirect()->route('cms::faqs.create')
        ->with('error', "Failed to add faq. " . $e->getMessage())
        ->withInput();
    }
  }

  /**
   * Show form to edit faq
   *
   * @param Faq $faq
   * @return View
   */
  public function edit(Faq $faq)
  {
    $this->authorize('update', Faq::class);

    $medias = $this->media->paginate(40, "created_at");

    return view('cms.faq.edit')
      ->with('faq', $faq)
      ->with('lastPage', $medias->lastPage());
  }

  /**
   * Update faq
   *
   * @param FaqRequest $request
   * @param $id
   * @return \Illuminate\Http\RedirectResponse
   */
  public function update(FaqRequest $request, $id)
  {
    $this->authorize('update', Faq::class);
    $faq = $this->faq->find($id);

    try {
      $this->db->beginTransaction();

      $input = $request->only([
        'question', 'answer', 'sort_order'
      ]);

      $input['publish'] = 0;

      if (isset($request->publish))
        $input['publish'] = 1;

      $this->faq->update($id, $input);
      $this->db->commit();

      return redirect()->route('cms::faqs.index')
        ->with('success', 'Faq updated successfully.')
        ->with('faq', $faq->id);
    } catch (\Exception $e) {
      $this->db->rollback();
      $this->log->error((string)$e);

      return redirect()->route('cms::faqs.edit', ['faq' => $id])
        ->with('error', 'Failed to update faq. ' . $e->getMessage())
        ->withInput();
    }
  }

  /**
   * Delete given faq
   *
   * @param Faq $faq
   * @return string
   */
  public function delete(Faq $faq)
  {
    $this->authorize('delete', Faq::class);

    try {
      $this->db->beginTransaction();
      $this->faq->delete($faq->id);

      $this->db->commit();
      return redirect()->route('cms::faqs.index')
        ->with('success', 'Faq deleted successfully.');
    } catch (\Exception $e) {
      $this->db->rollback();
      $this->log->error((string)$e);

      return redirect()->route('cms::faqs.index')
        ->with('error', 'Failed to delete faq.')
        ->withInput();
    }
  }

}
