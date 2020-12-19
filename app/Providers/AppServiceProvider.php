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
            $event->menu->add('Repositório');
            $event->menu->add([
                'text'        => 'Recursos TA',
                'url'         => '#',
                'icon'        => 'fa fa-puzzle-piece',
                'label'       =>  RecursoTA::where('publicacao_autorizada','false')->count(),
                'label_color' => 'warning',
            ]);
            $event->menu->add([
                'text'        => 'Tags',
                'url'         => '#',
                'icon'        => 'fa fa-tags',
                'label'       =>  Tag::where('publicacao_autorizada','false')->count(),
                'label_color' => 'warning',
            ]);
            $event->menu->add('Dados da conta');
            $event->menu->add([
                'text'        => 'Informações',
                'url'         => '#',
                'icon'        => 'fa fa-user',
            ]);
            $event->menu->add([
                'text'        => 'Redefinir senha',
                'url'         => '#',
                'icon'        => 'fa fa-key',
            ]);
            $event->menu->add('Gerenciar Contas');
            $event->menu->add([
                'text'        => 'Adicionar',
                'url'         => '#',
                'icon'        => 'fa fa-user-plus',
            ]);
            $event->menu->add([
                'text'        => 'Excluir',
                'url'         => '#',
                'icon'        => 'fa fa-user-times',
            ]);
        });
    }
}
