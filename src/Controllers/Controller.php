<?php

namespace AndreaMarelli\ModularForms\Controllers;

use AndreaMarelli\ModularForms\Controllers\Traits\API;
use AndreaMarelli\ModularForms\ModularForms;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * Class Controller
 *
 * @package AndreaMarelli\ModularForms\Controllers
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    use API;

    public function hello(): string
    {
        return view('modular-forms::hello', [
            'message' => ModularForms::hi()
        ]);
    }
}
