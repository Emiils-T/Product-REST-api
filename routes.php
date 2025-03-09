<?php

return [
    ['GET', '/Product-REST-api/api', [App\Controllers\Api\ProductController::class, 'index']],
    ['POST', '/Product-REST-api/api', [App\Controllers\Api\ProductController::class, 'store']],
    ['DELETE', '/Product-REST-api/api', [App\Controllers\Api\ProductController::class, 'destroy']]
];