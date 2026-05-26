<?php

return [
    '~^$~' => [\MyProject\Controllers\MainController::class, 'main'],
    '~^card/(\d+)/edit$~' => [\MyProject\Controllers\CardController::class, 'edit'],
    '~^card/(\d+)/delete$~' => [\MyProject\Controllers\CardController::class, 'delete'],
    '~^card/add$~' => [\MyProject\Controllers\CardController::class, 'add'],
];
