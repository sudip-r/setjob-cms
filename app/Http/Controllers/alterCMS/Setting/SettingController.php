<?php

namespace App\Http\Controllers\alterCMS\Setting;

use App\AlterBase\Repositories\Setting\MessageRepository;
use App\AlterBase\Repositories\Setting\NoticeRepository;
use App\AlterBase\Repositories\Setting\SettingRepository;
use App\AlterBase\Repositories\Setting\StripeRepository;
use App\AlterBase\Repositories\Setting\HomeSettingRepository;
use App\AlterBase\Repositories\User\UserRepository;
use App\AlterBase\Repositories\User\UserSettingRepository;
use App\Http\Controllers\Controller;
use App\Http\Requests\HomeSettingRequest;
use App\Http\Requests\SettingRequest;
use App\Http\Requests\StripeRequest;
use App\Http\Requests\UserSettingRequest;
use Illuminate\Database\DatabaseManager;
use Intervention\Image\Facades\Image;
use Psr\Log\LoggerInterface;
use Illuminate\Support\Facades\Storage;

/**
 * Class SettingController
 * @package App\Http\Controllers\CMS
 */
class SettingController extends Controller
{
    /**
     * @var UserSettingRepository
     */
    private $userSetting;
    /**
     * UserRepository $user
     */
    private $user;
    /**
     * @var MessageRepository
     */
    private $message;
    /**
     * @var NoticeRepository
     */
    private $notice;
    /**
     * @var SettingRepository
     */
    private $setting;
    /**
     * @var StripeRepository
     */
    private $stripe;
    /**
     * @var HomeSettingRepository
     */
    private $home;
    /**
     * @var LoggerInterface
     */
    private $log;
    /**
     * @var RoleRepository
     */
    private $role;
    /**
     * @var DatabaseManager
     */
    private $db;

    /**
     * UserController constructor.
     * @param UserSettingRepository $userSetting
     * @param UserRepository $user,
     * @param MessageRepository $message
     * @param NoticeRepository $notice
     * @param SettingRepository $setting
     * @param StripeRepository $stripe
     * @param HomeSettingRepository $home
     * @param LoggerInterface $log
     * @param DatabaseManager $db
     */
    public function __construct(
        UserSettingRepository $userSetting,
        UserRepository $user,
        MessageRepository $message,
        NoticeRepository $notice,
        SettingRepository $setting,
        StripeRepository $stripe,
        HomeSettingRepository $home,
        LoggerInterface $log,
        DatabaseManager $db) {
        $this->userSetting = $userSetting;
        $this->user = $user;
        $this->message = $message;
        $this->notice = $notice;
        $this->setting = $setting;
        $this->stripe = $stripe;
        $this->home = $home;
        $this->log = $log;
        $this->db = $db;
    }

    /**
     * Main site setting
     * 
     * @return \Illuminate\View\View
     */
    public function main()
    {
        $setting = $this->setting->findBy('id', 1);

        return view('cms.setting.main')
            ->with('setting', $setting);
    }

    /**
     * Update main settings
     * 
     * @param SettingRequest $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function updateMainSetting(SettingRequest $request)
    {
        $setting = $this->setting->find(1);

        try {
            $this->db->beginTransaction();

            $settings = $request->only([
                'trial_period', 'facebook', 'twitter', 'linkedin'
            ]);
            
            $this->setting->update($setting->id, $settings);

            $setting = $this->setting->find($setting->id);

            $filePath = storage_path('app/public/settings');

            if(!file_exists($filePath))
                mkdir($filePath, 0775);

            Storage::put('public/settings/settings.json', json_encode($setting));

            $this->db->commit();

            return redirect()->route('cms::settings.index')
                ->with('success', 'Settings updated successfully.');

        } catch (\Exception $e) {
            $this->db->rollback();
            $this->log->error((string) $e);

            return redirect()->route('cms::settings.index')
                ->with('error', 'Filed to update setting.')
                ->withInput();
        }
    }

    /**
     * Stripe setting
     * 
     * @return \Illuminate\View\View
     */
    public function stripe()
    {
        $stripe = $this->stripe->findBy('id', 1);

        return view('cms.setting.stripe')
            ->with('stripe', $stripe);
    }

    /**
     * Update stripe settings
     * 
     * @param SettingRequest $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function updateStripe(StripeRequest $request)
    {
        $stripe = $this->stripe->find(1);

        try {
            $this->db->beginTransaction();

            $input = $request->only([
                'test_publishable_key', 'test_secret_key', 'live_publishable_key', 'live_secret_key'
            ]);

            $input['live'] = 0;

            if(isset($request->live))
                $input['live'] = 1;

            $this->stripe->update($stripe->id, $input);

            $stripe = $this->setting->find($stripe->id);

            $filePath = storage_path('app/public/settings');

            if(!file_exists($filePath))
                mkdir($filePath, 0775);

            Storage::put('public/settings/stripe.json', json_encode($stripe));

            $this->db->commit();

            return redirect()->route('cms::settings.stripe')
                ->with('success', 'Stripe settings updated successfully.');

        } catch (\Exception $e) {
            $this->db->rollback();
            $this->log->error((string) $e);

            return redirect()->route('cms::settings.stripe')
                ->with('error', 'Filed to update stripe setting.')
                ->withInput();
        }
    }

    /**
     * Stripe setting
     * 
     * @return \Illuminate\View\View
     */
    public function home()
    {
        $home = $this->home->findBy('id', 1);

        return view('cms.setting.home')
            ->with('home', $home);
    }

    /**
     * Update stripe settings
     * 
     * @param SettingRequest $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function updateHome(HomeSettingRequest $request)
    {
        $home = $this->home->find(1);

        try {
            $this->db->beginTransaction();

            $input = $request->only([
                'title',
                'sub_title',
                'left_col_title',
                'left_col_summary',
                'left_col_btn',
                'left_col_btn_link',
                'right_col_title',
                'right_col_summary',
                'right_col_btn',
                'right_col_btn_link'
            ]);

            $this->home->update($home->id, $input);

            $home = $this->home->find($home->id);

            $filePath = storage_path('app/public/settings');

            if(!file_exists($filePath))
                mkdir($filePath, 0775);

            Storage::put('public/settings/home.json', json_encode($home));

            $this->db->commit();

            return redirect()->route('cms::settings.home')
                ->with('success', 'Settings updated successfully.');

        } catch (\Exception $e) {
            $this->db->rollback();
            $this->log->error((string) $e);

            return redirect()->route('cms::settings.home')
                ->with('error', 'Filed to update setting.')
                ->withInput();
        }
    }

    /**
     * Get user settings page
     *
     * @return \Illuminate\View\View
     */
    public function setting()
    {
        $user = auth()->user();

        $setting = $this->userSetting->findBy('user_id', $user->id);

        return view('cms.setting.setting')
            ->with('setting', $setting)
            ->with('user', $user);
    }

    /**
     * Update user setting
     *
     * @param $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function updateSetting(UserSettingRequest $request, $id)
    {
        $user = auth()->user();

        try {
            $this->db->beginTransaction();

            $input = $request->only([
                'name',
            ]);

            if ($request->hasFile('profile_image')) {
                $input['profile_image'] = $this->uploadImage($request);

                $this->deleteOldProfileImage($user->profile_image);
            }

            if ($request->password) {
                $input['password'] = $request->password;
            }

            $this->user->update($user->id, $input);

            $settings['dark_mode'] = false;
            if ($request->dark_mode) {
                $settings['dark_mode'] = true;
            }
            $this->userSetting->update($id, $settings);

            $this->db->commit();

            return redirect()->route('cms::settings.profile')
                ->with('success', 'User settings updated successfully.');

        } catch (\Exception $e) {
            $this->db->rollback();
            $this->log->error((string) $e);

            return redirect()->route('cms::settings.profile')
                ->with('error', 'Filed to update user setting.')
                ->withInput();
        }
    }




    /**
     * Get user messages
     *
     * @return \Illuminate\View\View
     */
    public function messages()
    {
        $user = auth()->user();

        $users = $this->user->getAllAdmin();

        $lastMessage = $this->message->findBy('user_id', $user->id);

        $lastSender = null;

        if ($lastMessage != null) {
            $lastSender = $lastMessage->message_from;
            if($lastMessage->message_from == $user->id)
                $lastSender = $lastMessage->message_to;
        }

        $latestThread = null;

        if ($lastSender != null) {
            $latestThread = $this->message->getMessageThread($user->id, $lastSender);
        }

        return view('cms.setting.message')
            ->with('user', $user)
            ->with('users', $users)
            ->with('lastMessage', $lastMessage)
            ->with('lastSender', $lastSender)
            ->with('latestThread', $latestThread);
    }

    /**
     * Upload image
     *
     * @param $request
     * @return string
     */
    private function uploadImage($request)
    {
        $image = $request->file('profile_image');
        $filename = rand(1, 1000000) . time() . '.' . $image->getClientOriginalExtension();

        $width = 256;
        $height = 256;

        $destinationPath = public_path('uploads/users/');

        $image->move($destinationPath, $filename);

        $filePath = $destinationPath . $filename;

        Image::make($filePath)
            ->fit($width, $height, function ($constraint) {
                $constraint->upsize();
            })
            ->save($destinationPath . $filename);

        return $filename;
    }

    /**
     * Delete old image
     *
     * @param $image
     * @return Boolean
     */
    private function deleteOldProfileImage($image)
    {
        $path = public_path('uploads/users/');

        if (file_exists($path . $image)) {
            unlink($path . $image);
        } else {
            return false;
        }
        return true;
    }

}
