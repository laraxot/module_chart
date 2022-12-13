<?php

//*
return [
    'Getting Started' => [
        'url' => 'docs/getting-started',
        'children' => [
            'Customizing Your Site' => ['url'=>'docs/customizing-your-site'],
            'Navigation' => ['url'=>'docs/navigation'],
            'Algolia DocSearch' => ['url'=>'docs/algolia-docsearch'],
            'Custom 404 Page' => ['url'=>'docs/custom-404-page'],
        ],
    ],
    'Jigsaw Docs' => 'https://jigsaw.tighten.co/docs/installation',
];
//*/

/*
$data=[];
foreach ($docs as $doc) {
    $k=$doc->title;
    $v=['url'=>$doc->getPath()];
    $data[$k]=$v;
}
*/
//ddd(get_defined_vars());
//return $data;
