<?php

// list of accessible routes of your application, add every new route here
// key : route to match
// values : 1. controller name
//          2. method name
//          3. (optional) array of query string keys to send as parameter to the method
// e.g route '/item/edit?id=1' will execute $itemController->edit(1)
return [
    '' => ['HomeController', 'home'],
    'post/index' => ['PostController', 'index', ['postsList']],
    'post/show' => ['PostController', 'show', ['id']],
    'post/add' => ['PostController', 'add'],
    'post/search' => ['PostController', 'search', ['keywords']],
    'categories/index' => ['PostController', 'categoryIndex', ['categories']],
    'category/results' => ['PostController', 'categoryShowAllPosts', ['category']],
];
