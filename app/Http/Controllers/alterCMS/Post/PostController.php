<?php

namespace App\Http\Controllers\alterCMS\Post;

use App\AlterBase\Models\Post\Post;
use App\AlterBase\Repositories\Post\PostRepository;
use App\Http\Requests\PostRequest;
use App\AlterBase\Repositories\Media\MediaRepository;
use App\AlterBase\Repositories\Category\CategoryRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use Illuminate\Database\DatabaseManager;
use Illuminate\View\View;
use Psr\Log\LoggerInterface;
use Carbon\Carbon;

class PostController extends Controller
{
  /**
   * PostRepository $post
   */
  private $post;

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
   * PostController constructor.
   * @param PostRepository $post
   * @param MediaRepository $media
   * @param CategoryRepository $category
   * @param DatabaseManager $db
   * @param LoggerInterface $log
   */
  public function __construct(
    PostRepository $post,
    MediaRepository $media,
    CategoryRepository $category,
    DatabaseManager $db,
    LoggerInterface $log
  ) {
    $this->post     = $post;
    $this->media    = $media;
    $this->category = $category;
    $this->db       = $db;
    $this->log      = $log;
  }

  /**
   * Show all post
   *
   * @param Request $request
   * @return View
   */
  public function index(Request $request)
  {
    $this->authorize('view', Post::class);
    $currentPage = $request->page ?? 1;
    $posts = $this->post->paginateWithMultipleCondition(['trash' => false, 'post_type' => 'post'], 'published_on', 'desc',40, ['*'],$currentPage);

    // $categories = $this->category->getBy('publish', 1, ['id', 'category', 'parent', 'publish']);

    return view('cms.post.index')
      ->with('posts', $posts)
      ->with('user', auth()->user());
      // ->with('categories', $categories);
  }

  /**
   * Search post
   *
   * @param Request $request
   * @return View
   */
  public function search(Request $request)
  {
    $this->authorize('view', Post::class);
    $posts = $this->post->searchPost(['trash' => false, 'post_type' => 'post'], $request->search_txt, "id", "desc", ['*'], 40);

    // $categories = $this->category->getBy('publish', 1, ['id', 'category', 'parent', 'publish']);

    return view('cms.post.index')
      ->with('posts', $posts)
      ->with("searchTxt", $request->search_txt)
      ->with('user', auth()->user());
      // ->with('categories', $categories);
  }

  /**
   * Show form to create new post
   *
   * @return View
   */
  public function create()
  {
    $this->authorize('create', Post::class);

    $medias = $this->media->paginate(40, "created_at");

    // $categories = $this->category->getWithCondition(['publish' => 1, 'type' => 'Category']);

    return view('cms.post.create')
      // ->with('categories', $categories)
      ->with('lastPage', $medias->lastPage());
  }

  /**
   * Store newly created post
   *
   * @param PostRequest $request
   * @return $this|\Illuminate\Http\RedirectResponse
   */
  public function store(PostRequest $request)
  {
    $this->authorize('create', Post::class);
    try {
      $this->db->beginTransaction();

      $input = $request->only([
        'title', 'slug', 'post_type', 'author', 'summary', 'description', 'last_modified', 'image', 'video', 'published_on'
      ]);

      $input['slug'] = strtolower(str_replace(" ", "-",$input['title']))."-".date("his");

      $input['publish'] = 0;

      $user = auth()->user()->id;

      $input['author'] = $user;
      $input['last_modified'] = $user;

      if (isset($request->publish))
        $input['publish'] = 1;

      $post = $this->post->store($input);

      // $post->cats()->sync($request->input('category'));

      $this->db->commit();

      // $categories = $request->input('category');

      return redirect()->route('cms::posts.index')
        // ->with('categories', $categories)
        ->with('success', "Post added successfully.");
    } catch (\Exception $e) {
      $this->db->rollback();
      $this->log->error((string)$e);

      return redirect()->route('cms::posts.create')
        ->with('error', "Failed to add tag. " . $e->getMessage())
        ->withInput();
    }
  }

  /**
   * Show form to edit post
   *
   * @param Post $post
   * @return View
   */
  public function edit(Post $post)
  {
    $this->authorize('update', Post::class);

    $medias = $this->media->paginate(40, "created_at");

    // $categories = $this->category->getWithCondition(['publish' => 1, 'type' => 'Category']);

    // $assignedCat = $post->cats()->pluck('categories.id')->toArray();
    
    return view('cms.post.edit')
      ->with('post', $post)
      // ->with('assignedCat', $assignedCat)
      // ->with('categories', $categories)
      ->with('lastPage', $medias->lastPage());
  }

  /**
   * Update post detail
   *
   * @param ProductPostRequest $request
   * @param $id
   * @return \Illuminate\Http\RedirectResponse
   */
  public function update(PostRequest $request, $id)
  {
    $this->authorize('update', Post::class);

    $post = $this->post->find($id);
    try {
      $this->db->beginTransaction();

      $input = $request->only([
        'title', 'slug', 'post_type', 'author', 'summary', 'description', 'last_modified', 'image', 'video', 'published_on'
      ]);

      $input['publish'] = 0;

      if (isset($request->publish))
        $input['publish'] = 1;

      $user = auth()->user()->id;

      $input['last_modified'] = $user;

      $this->post->update($id, $input);
      
      // $post->cats()->sync($request->input('category'));
      
      $this->db->commit();

      // $categories = $request->input('category');

      return redirect()->route('cms::posts.index')
        ->with('success', 'Post updated successfully.');
        // ->with('categories', $categories);
    } catch (\Exception $e) {
      $this->db->rollback();
      $this->log->error((string)$e);

      return redirect()->route('cms::posts.edit', ['post' => $id])
        ->with('error', 'Filed to update post. ' . $e->getMessage())
        ->withInput();
    }
  }

  /**
   * Delete given post
   *
   * @param Post $post
   * @return string
   */
  public function delete(Post $post)
  {
    $this->authorize('delete', Post::class);

    try {
      $this->db->beginTransaction();
      $this->post->update($post->id, ['trash' => 1]);

      $this->db->commit();
      return redirect()->route('cms::posts.index')
        ->with('success', 'Post deleted successfully.');
    } catch (\Exception $e) {
      $this->db->rollback();
      $this->log->error((string)$e);

      return redirect()->route('cms::posts.index')
        ->with('error', 'Filed to delete post.')
        ->withInput();
    }
  }

  /**
   * Update post detail
   *
   * @param ProductPostRequest $request
   * @param $id
   * @return \Illuminate\Http\RedirectResponse
   */
  public function statusToggle(Post $post)
  {
    $this->authorize('status', Post::class);

    try {
      $this->db->beginTransaction();

      if ($post->publish)
        $input['publish'] = 0;
      else 
        $input['publish'] = 1;

      $this->post->update($post->id, $input);
      $this->db->commit();

      if(auth()->user()->id != 1){
        if($input['published'] == 1)
          logger("Post ".$post->title." published by ".auth()->user()->name);
        if($input['published'] == 0)
          logger("Post ".$post->title." unpublished by ".auth()->user()->name);
      }
      clearCache('On status update');


      return redirect()->route('cms::posts.index')
        ->with('success', 'Post updated successfully.')
        ->with('latest', $post);

    } catch (\Exception $e) {
      $this->db->rollback();
      $this->log->error((string)$e);

      return redirect()->route('cms::posts.edit', ['post' => $post->id])
        ->with('error', 'Filed to update post. ' . $e->getMessage())
        ->withInput();
    }
  }

  /**
   * Update post detail
   *
   * @param ProductPostRequest $request
   * @param $id
   * @return \Illuminate\Http\RedirectResponse
   */
  public function quickSave(Request $request, $id)
  {
    $this->authorize('update', Post::class);

    try {
      $this->db->beginTransaction();

      $input = $request->only([
        'title',
        'category',
        'published_on',
      ]);
      $input['author_id'] = $request->reporter;

      $userId = auth()->user()->id;
      if($userId != 1)
        $input['last_modified'] = $userId;

      $input['tag_line'] = $this->registerTags($request->tag_line);
      $input['post_type'] = 'news';

      $this->post->update($request->id, $input);
      $this->db->commit();
      $post = $this->post->find($request->id);

      if(auth()->user()->id != 1)
        logger("Post ".$input['title']." updated by ".auth()->user()->name);

      if($input['published_on'] > Carbon::now())
      {
        $this->storeCacheClearDates($input['published_on']);
      }
      clearCache('On news update');

      return response(['category' => $post->category_info, 'author' => $post->author()->name], 200);
    } catch (\Exception $e) {
      $this->db->rollback();
      $this->log->error((string)$e);

      return response('Something went wrong '.$e->getMessage(), 500);

    }
  }
}
