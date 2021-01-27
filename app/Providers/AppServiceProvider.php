<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Events\Dispatcher;
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
        config(['app.locale' => 'pt_BR']);
        \Carbon\Carbon::setLocale('pt_BR');

        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {
            $event->menu->add('Administrar Repositório');
            $event->menu->add([
                'text'        => 'Recursos TA',
                'url'         => url('/administrarRecursosTA'),
                'icon'        => 'fa fa-puzzle-piece',
                'label'       =>  RecursoTA::where('publicacao_autorizada','false')->count(),
                'label_color' => 'warning',
            ]);
            $event->menu->add([
                'text'        => 'Tags',
                'url'         => url('/administrarTags'),
                'icon'        => 'fa fa-tags',
                'label'       =>  Tag::where('publicacao_autorizada','false')->count(),
                'label_color' => 'warning',
            ]);
            $event->menu->add('Administrar Páginas');
            $event->menu->add([
                'text'        => 'Aprender',
                'url'         => url('/editarPaginaAprender'),
                'icon'        => 'fa fa-book',
            ]);
            $event->menu->add([
                'text'        => 'Sobre',
                'url'         => url('/editarPaginaSobre'),
                'icon'        => 'fa fa-info',
            ]);
            $event->menu->add('Administrar Usuários');
            $event->menu->add([
                'text'        => 'Usuários',
                'url'         => url('/administrarUsuarios'),
                'icon'        => 'fa fa-users',
            ]);           
            $event->menu->add('Dados da conta');
            $event->menu->add([
                'text'        => 'Informações',
                'url'         => url('/informacoesUsuario'),
                'icon'        => 'fa fa-id-card',
            ]);
        });
    }
}
