<?php

return [
    ['GET', '/scandiweb-test/api', [App\Controllers\Api\ProductController::class, 'index']],
    ['POST', '/scandiweb-test/api', [App\Controllers\Api\ProductController::class, 'store']]
];