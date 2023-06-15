<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Setting as Table;

class SettingController extends Controller {
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct() {
    $this->middleware('auth');
  }

  public function index() {
    $settings = getSettings();
    return kview('settings.general', [
      'form_action' => route('admin.settings.update'),
      'edit' => 1,
      'settings' => $settings,
    ]);
  }
  public function edit_profile() {
    $user = Auth::user();
    $roles = Role::get();
    return kview('users.manage', [
      'form_action' => route('admin.users.update'),
      'edit' => 1,
      'data' => $user,
      'roles' => $roles,
    ]);
  }

  public function update(Request $request) {
    if (isset($request->SITE_NAME)) {
      $this->updateSetting('SITE_NAME', $request->SITE_NAME);
    }
    if (isset($request->site_url)) {
      $this->updateSetting('site_url', $request->site_url);
    }
    if (isset($request->tagline)) {
      $this->updateSetting('tagline', $request->tagline);
    }
    if (isset($request->theme)) {
      $this->updateSetting('theme', $request->theme);
    }
    return redirect()->back()->with('success', 'Settings has been updated');
  }
  public function updateSetting($key, $value) {
    $where = [
      'key' => $key,
    ];
    $update_array = [
      'value' => $value,
    ];
    Table::updateOrCreate($where, $update_array);
  }
}
