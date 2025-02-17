<?php
/**
 * @license MIT
 *
 * Modified by owc on 18-February-2025 using {@see https://github.com/BrianHenryIE/strauss}.
 */

namespace OWCAD\Vendor_Prefixed\Laravel\SerializableClosure\Contracts;

interface Serializable
{
    /**
     * Resolve the closure with the given arguments.
     *
     * @return mixed
     */
    public function __invoke();

    /**
     * Gets the closure that got serialized/unserialized.
     *
     * @return \Closure
     */
    public function getClosure();
}
