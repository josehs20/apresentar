<?php

namespace App\Providers;

use App\Models\ConfiguracaoSite;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // View Composer global: injeta as cores dinâmicas em todas as views
        View::composer('*', function ($view) {
            $cores = Cache::remember('cores_site', now()->addHour(), function () {
                $registros = ConfiguracaoSite::where('grupo', 'cores')->get()->keyBy('chave');

                return [
                    '--primary'       => $registros->get('cor_primary')?->valor ?? '#76877D',
                    '--primary-light' => $registros->get('cor_primary_light')?->valor ?? '#8B9F95',
                    '--secondary'     => $registros->get('cor_secondary')?->valor ?? '#96958A',
                    '--accent'        => $registros->get('cor_accent')?->valor ?? '#88B8A9',
                    '--accent-light'  => $registros->get('cor_accent_light')?->valor ?? '#9CC8BB',
                    '--border-soft'   => $registros->get('cor_border_soft')?->valor ?? '#B2CBAE',
                    '--light'         => $registros->get('cor_light')?->valor ?? '#F8F6F0',
                    '--light-2'       => $registros->get('cor_light_2')?->valor ?? '#F0EDE5',
                    '--dark'          => $registros->get('cor_dark')?->valor ?? '#2B2B2B',
                ];
            });

            $view->with('coresSite', $cores);
        });
    }
}
