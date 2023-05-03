<?php

namespace App\Http\Controllers\alterCMS\Partner;

use App\AlterBase\Models\Partner\Partner;
use App\AlterBase\Repositories\Partner\PartnerRepository;
use App\Http\Requests\PartnerRequest;
use App\AlterBase\Repositories\Media\MediaRepository;
use App\AlterBase\Repositories\Category\CategoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\DatabaseManager;
use Illuminate\View\View;
use Psr\Log\LoggerInterface;

class PartnerController extends Controller
{
  /**
   * PartnerRepository $partner
   */
  private $partner;

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
   * PartnerController constructor.
   * @param PartnerRepository $partner
   * @param MediaRepository $media
   * @param DatabaseManager $db
   * @param LoggerInterface $log
   */
  public function __construct(
    PartnerRepository $partner,
    MediaRepository $media,
    DatabaseManager $db,
    LoggerInterface $log
  ) {
    $this->partner     = $partner;
    $this->media    = $media;
    $this->db       = $db;
    $this->log      = $log;
  }

  /**
   * Show all partner
   *
   * @return View
   */
  public function index()
  {
    $this->authorize('view', Partner::class);
    $partners = $this->partner->paginate();

    return view('cms.partner.index')
      ->with('partners', $partners);
  }

  /**
   * Search partner
   *
   * @param Request $request
   * @return View
   */
  public function search(Request $request)
  {
    $this->authorize('view', Partner::class);
    $partners = $this->partner->searchPartner([], $request->search_txt, "id", "desc", ['*'], 40);

    return view('cms.partner.index')
      ->with('partners', $partners)
      ->with("searchTxt", $request->search_txt);
  }

  /**
   * Show form to create new partner
   *
   * @return View
   */
  public function create()
  {
    $this->authorize('create', Partner::class);

    $medias = $this->media->paginate(40, "created_at");

    return view('cms.partner.create')
      ->with('lastPage', $medias->lastPage());
  }

  /**
   * Store newly created partner
   *
   * @param PartnerRequest $request
   * @return $this|\Illuminate\Http\RedirectResponse
   */
  public function store(PartnerRequest $request)
  {
    $this->authorize('create', Partner::class);
    try {
      $this->db->beginTransaction();

      $input = $request->only([
        'partner_name', 'image', 'partner_link', 'summary', 'description', 'sort_order'
      ]);

      $input['publish'] = 0;

      if (isset($request->publish))
        $input['publish'] = 1;

      $partner = $this->partner->store($input);

      $this->db->commit();

      return redirect()->route('cms::partners.index')
        ->with('success', "Partner added successfully.")
        ->with('partner', $partner->id);
    } catch (\Exception $e) {
      $this->db->rollback();
      $this->log->error((string)$e);

      return redirect()->route('cms::partners.create')
        ->with('error', "Failed to add partner. " . $e->getMessage())
        ->withInput();
    }
  }

  /**
   * Show form to edit partner
   *
   * @param Partner $partner
   * @return View
   */
  public function edit(Partner $partner)
  {
    $this->authorize('update', Partner::class);

    $medias = $this->media->paginate(40, "created_at");

    return view('cms.partner.edit')
      ->with('partner', $partner)
      ->with('lastPage', $medias->lastPage());
  }

  /**
   * Update partner
   *
   * @param PartnerRequest $request
   * @param $id
   * @return \Illuminate\Http\RedirectResponse
   */
  public function update(PartnerRequest $request, $id)
  {
    $this->authorize('update', Partner::class);
    $partner = $this->partner->find($id);

    try {
      $this->db->beginTransaction();

      $input = $request->only([
        'partner_name', 'image', 'partner_link', 'summary', 'description', 'sort_order'
      ]);

      $input['publish'] = 0;

      if (isset($request->publish))
        $input['publish'] = 1;

      $this->partner->update($id, $input);
      $this->db->commit();

      return redirect()->route('cms::partners.index')
        ->with('success', 'Partner updated successfully.')
        ->with('partner', $partner->id);
    } catch (\Exception $e) {
      $this->db->rollback();
      $this->log->error((string)$e);

      return redirect()->route('cms::partners.edit', ['partner' => $id])
        ->with('error', 'Failed to update partner. ' . $e->getMessage())
        ->withInput();
    }
  }

  /**
   * Delete given partner
   *
   * @param Partner $partner
   * @return string
   */
  public function delete(Partner $partner)
  {
    $this->authorize('delete', Partner::class);

    try {
      $this->db->beginTransaction();
      $this->partner->delete($partner->id);

      $this->db->commit();
      return redirect()->route('cms::partners.index')
        ->with('success', 'Partner deleted successfully.');
    } catch (\Exception $e) {
      $this->db->rollback();
      $this->log->error((string)$e);

      return redirect()->route('cms::partners.index')
        ->with('error', 'Failed to delete partner.')
        ->withInput();
    }
  }

}
