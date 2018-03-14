<?php
/**
 * Created by PhpStorm.
 * User: fabian
 * Date: 14.03.2018
 * Time: 10:31
 */

namespace App\Model;

use Nette\Database\Context;
use Nette\SmartObject;

abstract class BaseManager
{

    use SmartObject;

    protected $database;

    /**
     * BaseManager constructor.
     * @param Context $database
     */
    public function __construct(Context $database)
    {
        $this->database = $database;
    }


}