<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Tightenco\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
  /**
   * The root template that is loaded on the first page visit.
   *
   * @var string
   */
  protected $rootView = 'app';

  /**
   * Determine the current asset version.
   */
  public function version(Request $request): string|null
  {
    return parent::version($request);
  }

  /**
   * Define the props that are shared by default.
   *
   * @return array<string, mixed>
   */
  public function share(Request $request): array
  {
    return array_merge(parent::share($request), [
      'auth' => [
        //'user' => $request->user()->toArray(),
        'user' => ($request->user() && $request->user()->roles()) ? array_merge($request->user()->toArray(), ['roles' => $request->user()->roles()->get()]) : ($request->user() ? array_merge($request->user()->toArray(), ['roles' => []]) : $request->user()),
        'roles' => ($request->user() && $request->user()->roles()) ? $request->user()->roles()->get() : [],
        'settings' => ($request->user() && $request->user()->settings) ? $request->user()->settings : [
          'start1' => '06:00',
          'end1' => '14:00',
          'start2' => '14:00',
          'end2' => '22:00',
          'start3' => '22:00',
          'end3' => '06:00',
        ],
        'is_admin' =>  $request->user() ? $request->user()->hasAnyRoles(['superadmin', 'admin']) : false,
      ],
      'impersonate' => [
        'id' => session()->get('impersonate'),
      ],
      'ziggy' => function () use ($request) {
        return array_merge((new Ziggy)->toArray(), [
          'location' => $request->url(),
        ]);
      },
    ]);
  }
}
