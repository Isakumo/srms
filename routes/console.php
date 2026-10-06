<?php

use Illuminate\Support\Facades\Artisan;

Artisan::command('phase:status', function () {
    $this->info('Phase 0 initialized. Next step: implement Phase 1 identity and RBAC.');
});
