<?php

namespace Xypp\Store;

use Flarum\Extend;
use Flarum\Api\Serializer\ForumSerializer;
use Flarum\Api\Serializer\BasicUserSerializer;
use Flarum\Foundation\AbstractServiceProvider;
use Flarum\Settings\SettingsRepositoryInterface;
use Flarum\User\User;
use Flarum\Post\Post;
use Illuminate\Events\Dispatcher;
use Flarum\Frontend\Document;
use Flarum\Frontend\AddRenderer;
use Flarum\Frontend\Header;
use Flarum\Frontend\Content;
use Flarum\Frontend\FlarumFrontend;

return [
    (new Extend\Frontend('forum'))
        ->css(__DIR__ . '/resources/less/store.less')
        ->js(__DIR__ . '/resources/js/dist/extension.js'),

    // Veritabanı işlemleri
    (new Extend\Database())
        ->migrator(function () {
            return [
                __DIR__ . '/migrations/create_store_table.php',
            ];
        }),

    // Admin kontrolü
    (new Extend\Routes('api'))
        ->get('/store/{id}', 'store.show', 'storeController@show')
        ->post('/store/create', 'store.create', 'storeController@create')
        ->delete('/store/{id}', 'store.delete', 'storeController@delete'),

    // Dashboard için store modelini ekle
    (new Extend\Model(Post::class))
        ->relationship('store', StoreItem::class)
];
