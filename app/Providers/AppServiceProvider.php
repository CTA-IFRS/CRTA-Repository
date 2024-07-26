<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use Carbon\Carbon;
use App\RecursoTA;
use App\Tag;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Dispatcher $events)
    {
        Schema::defaultStringLength(191);

        config(['app.locale' => 'pt_BR']);
        \Carbon\Carbon::setLocale('pt_BR');

        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            $event->menu->add('Administrar Repositório');
            $event->menu->add([
                'text'        => 'Recursos TA',
                'url'         => route('administrarRecursosTA'),
                'icon'        => 'fa fa-puzzle-piece',
                'label'       =>  RecursoTA::where('publicacao_autorizada','false')->count(),
                'label_color' => 'warning',
            ]);
            $event->menu->add([
                'text'        => 'Tags',
                'url'         => route('administrarTags'),
                'icon'        => 'fa fa-tags',
                'label'       =>  Tag::where('publicacao_autorizada','false')->count(),
                'label_color' => 'warning',
            ]);
            $event->menu->add('Administrar Páginas');
            $event->menu->add([
                'text'        => 'Aprender',
                'url'         => route('editarPaginaAprender'),
                'icon'        => 'fa fa-book',
            ]);
            $event->menu->add([
                'text'        => 'Sobre',
                'url'         => route('editarPaginaSobre'),
                'icon'        => 'fa fa-info',
            ]);
            if (Auth::user()->isRoot()) {
                $event->menu->add('Administrar Usuários');
                $event->menu->add([
                    'text'        => 'Usuários',
                    'url'         => route('administrarUsuarios'),
                    'icon'        => 'fa fa-users',
                ]);           
            }
            $event->menu->add('Dados da conta');
            $event->menu->add([
                'text'        => 'Informações',
                'url'         => route('informacoesUsuario'),
                'icon'        => 'fa fa-id-card',
            ]);
        });

        Paginator::useBootstrapFour();
    }
}
