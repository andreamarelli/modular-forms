<?php

namespace ModularForms\Controllers;

use ModularForms\Controllers\Traits\API;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * Class Controller
 *
 * @package ModularForms\Controllers
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    use API;

}
