<?php
/**
 * @license MIT
 *
 * Modified by owc on 18-February-2025 using {@see https://github.com/BrianHenryIE/strauss}.
 */

namespace OWCAD\Vendor_Prefixed\Laravel\SerializableClosure\Support;

class SelfReference
{
    /**
     * The unique hash representing the object.
     *
     * @var string
     */
    public $hash;

    /**
     * Creates a new self reference instance.
     *
     * @param  string  $hash
     * @return void
     */
    public function __construct($hash)
    {
        $this->hash = $hash;
    }
}
