<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Pagination\Paginator;
use App\Models\Setting;
use App\Models\Menu;
use App\Models\Blog;
use App\Models\Gallery;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use App\Models\SliderIcon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Cache layout metadata for 24 hours and share globally across all views, layouts and partials
        try {
            $layoutData = Cache::remember('global_layout_shared_data', 86400, function () {
                return [
                    'setting'       => Setting::find(1),
                    'footerGallery' => Gallery::orderBy('order', 'asc')->images()->limit(6)->get(),
                    'Headerblogs'   => Blog::latest()->limit(5)->get(),
                    'topbarMenus'   => Menu::where('parent_id', null)->type(2)->active()->orderBy('order')->get(),
                    'footerMenus'   => Menu::where('parent_id', null)->type(1)->active()->orderBy('order')->get(),
                    'headerMenus'   => Menu::where('parent_id', null)->with('children.children')->type(0)->active()->orderBy('order')->get(),
                    'slidericon'    => SliderIcon::all(),
                ];
            });

            if (is_array($layoutData)) {
                foreach ($layoutData as $key => $value) {
                    View::share($key, $value);
                }
            }
        } catch (\Throwable $e) {
            // Failsafe for migrations or database maintenance
        }

        Gate::before(function ($user, $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });

        Paginator::useBootstrapFive();
    }
}

