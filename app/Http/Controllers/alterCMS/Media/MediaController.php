<?php

namespace App\Http\Controllers\alterCMS\Media;

use App\AlterBase\Models\Media\Media;
use App\AlterBase\Repositories\Media\MediaRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Database\DatabaseManager;
use Illuminate\View\View;
use Psr\Log\LoggerInterface;
use Intervention\Image\Facades\Image;

class MediaController extends Controller
{
  /**
   * MediaRepository $media
   */
  private $media;

  /**
   * @var DatabaseManager
   */
  private $db;

  /**
   * @var LoggerInterface
   */
  private $log;

  /**
   * @var $pagination
   */
  private $pagination;

  /**
   * CategoryController constructor.
   * @param MediaRepository $media
   * @param DatabaseManager $db
   * @param LoggerInterface $log
   */
  public function __construct(
    MediaRepository $media,
    DatabaseManager $db,
    LoggerInterface $log
  ) {
    $this->media = $media;
    $this->db   = $db;
    $this->log  = $log;
    $this->pagination = 40;
  }

  /**
   * Show all media
   *
   * @return View
   */
  public function index()
  {
    $this->authorize('view', Media::class);
    $medias = $this->media->paginate($this->pagination, "created_at");


    return view('cms.media.index')->with('medias', $medias)->with('lastPage', $medias->lastPage());
  }

  /**
   * List all media api
   * 
   * @return Response
   */
  public function listMedia($search = "")
  {
    $medias = $this->media->paginate($this->pagination, "created_at");

    if($search != "")
      $medias = $this->media->paginateWithCondition('name',$search, 'created_at', 'desc', $this->pagination);

    return response([
      'media' => $medias
    ]);
  }

  /**
   * Update media file
   * 
   * @param Request $request
   * @return Response
   */
  public function updateMedia(Request $request)
  {
    try {
      $this->db->beginTransaction();

      $input = ['name' => $request->caption];

      $media = $this->media->find($request->id);

      $media->update($input);

      $this->db->commit();

      return response()->json([
        'status' => 'success',
        'data' => $media,
        'message' => "Media updated successfully."
      ], 200);
    } catch (\Exception $e) {
      $this->db->rollback();

      $this->log->error((string)$e);

      return response()->json([
        'status' => 'error',
        'message' => "Failed to update media."
      ], 500);
    }
    return response($request);
  }

  /**
   * Delete media file
   * 
   * @param Request $request
   * @return Response
   */
  public function deleteMedia(Request $request)
  {
    $media = $this->media->find($request->id);

    try {
      $this->db->beginTransaction();

      $this->deleteImage($media);
      $media->delete();
      
      $this->db->commit();

      return response()->json([
        'success' => 'Record deleted successfully!'
      ]);
    } catch (\Exception $e) {
      $this->db->rollBack();

      $this->log->error((string)$e);

      return response()->json([
        'error' => 'Failed to delete record.'
      ]);
    }
  }

  /**
   * Upload files
   * 
   * @param Request $request
   * @return Json Response
   */
  public function uploadFiles(Request $request)
  {
    if ($request->hasFile('mediaFiles')) {
      $file = $request->file('mediaFiles');

      $root = public_path('uploads/media');

      $year = $root . "/" . date("Y");
      $month = $year . "/" . date("m");
      $day = $month . "/" . date("d");

      try {
        if (!file_exists($root))
          mkdir($root, 0775, true);

        if (!file_exists($year))
          mkdir($year, 0775, true);

        if (!file_exists($month))
          mkdir($month, 0775, true);

        if (!file_exists($day))
          mkdir($day);
      } catch (\Exception $e) {
        //Do nothing
      }
      try {

        $size = $file->getSize();
        $filename = explode(".", $file->getClientOriginalName())[0];
        $uploadName = rand(11111, 99999) . time() . "." . $file->getClientOriginalExtension();
        $filePath = $day . "/" . $uploadName;
        $file->move($day, $uploadName);

        $url = asset("uploads/media") . "/" . date("Y") . "/" . date("m") . "/" . date("d") . "/" . $uploadName;
        //$data = getimagesize($url);
        $data = ['0','0'];


        //Create Thumbnails
        $sizes = config('cms.image_sizes');

        $thumbnails = [];
        foreach ($sizes as $img) {
          $width = $img[0];
          $height = $img[1] ?? null;
          $imagePath = $day;
          $thumbUrl = asset("uploads/media") . "/" . date("Y") . "/" . date("m") . "/" . date("d") . "/" . $width . "X" . $height . "_" . $uploadName;

          $thumbnails[$width . "X" . $height] = $thumbUrl;
          if (!file_exists($imagePath)) {
            mkdir($imagePath, 0775, true);
          }
          if ($height == null) {
            Image::make($filePath)
              ->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
              })
              ->save($imagePath . '/' . $width . 'X' . $height . '_' . $uploadName);
          } else {
            Image::make($filePath)
              ->fit($width, $height, function ($constraint) {
                $constraint->upsize();
              })
              ->save($imagePath . '/' . $width . 'X' . $height . '_' . $uploadName);
          }
        }

        $width = $data[0];
        $height = $data[1];
        $store = [
          "name" => $filename,
          "file_name" => $uploadName,
          "url" => $url,
          "size" => $size / 1024,
          "resolution" => $width . "X" . $height,
          "thumbnails" => json_encode($thumbnails)
        ];

        $this->media->store($store);

        return json_encode(["success" => true]);
      } catch (\Exception $e) {
        $this->log->error((string)$e);
        return json_encode([
          "success" => false,
          "message" => $e->getMessage()
        ]);
      }
    }
    return json_encode(["success" => false]);
  }

  /**
   * Delete all associated Images
   * 
   * @param $media
   * @return boolean
   */
  private function deleteImage($media)
  {
    $year = date("Y", strtotime($media->created_at));
    $month = date("m", strtotime($media->created_at));
    $day = date("d", strtotime($media->created_at));
    $path = public_path('uploads/media/'.$year.'/'.$month.'/'.$day.'/');
    $file_name = $media->file_name;

    if(file_exists($path.$file_name))
    {
      //Thumbnails
      $sizes = config('cms.image_sizes');
      foreach ($sizes as $img) {
        $width = $img[0];
        $height = $img[1] ?? null;
        if(file_exists($path.$width."X".$height."_".$file_name))
        {
          unlink($path.$width."X".$height."_".$file_name);
        }
      }
      unlink($path.$file_name);
      
    }else{
      return false;
    }
    return true;

  }
}
