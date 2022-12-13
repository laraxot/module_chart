<?php

use Illuminate\Support\Str;

return [
    'baseUrl' => '',
    'production' => false,
    'siteName' => 'Docs Starter Template',
    'siteDescription' => 'Beautiful docs powered by Jigsaw',
    'lang'=>'it',
    /*
    'path' => function ($page) {
        return $page->lang.'/'.$page->collection.'/' . Str::slug($page->getFilename());
    },
    */

    'collections' => [
        'posts'=>[
            'path'=>function ($page) {
                return $page->lang.'/posts/' . Str::slug($page->getFilename());
            },
        ],
        'docs'=>[
            'path'=>function ($page) {
                return $page->lang.'/docs/' . Str::slug($page->getFilename());
            },
        ]
    ],

    /*
    'path' => '{language}/{type}/{-title}',

    'collections' => [
       'docs-it' => [
            'type' => 'docs',
            'language' => 'it',
        ],

        'docs-en' => [
            'type' => 'docs',
            'language' => 'en',
        ],
        'posts',
    ],
    */

    // Algolia DocSearch credentials
    'docsearchApiKey' => env('DOCSEARCH_KEY'),
    'docsearchIndexName' => env('DOCSEARCH_INDEX'),

    // navigation menu
    'navigation' => require_once('navigation.php'),

    // helpers
    'isActive' => function ($page, $path) {
        return Str::endsWith(trimPath($page->getPath()), trimPath($path));
    },
    'isActiveParent' => function ($page, $menuItem) {
        if (is_object($menuItem) && $menuItem->children) {
            return $menuItem->children->contains(function ($child) use ($page) {
                return trimPath($page->getPath()) == trimPath($child);
            });
        }
    },
    'url' => function ($page, $path) {
        if (Str::startsWith($path, 'http')) {
            return $path;
        }
        //return Str::startsWith($path, 'http') ? $path : '/' . trimPath($path);
        return '/'.$page->lang.'/'.trimPath($path);
    },
];
