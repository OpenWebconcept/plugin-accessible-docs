<?php
/**
 * @license MIT
 *
 * Modified by owc on 18-February-2025 using {@see https://github.com/BrianHenryIE/strauss}.
 */ declare(strict_types=1);

namespace OWCAD\Vendor_Prefixed\Invoker;

use OWCAD\Vendor_Prefixed\Invoker\Exception\InvocationException;
use OWCAD\Vendor_Prefixed\Invoker\Exception\NotCallableException;
use OWCAD\Vendor_Prefixed\Invoker\Exception\NotEnoughParametersException;

/**
 * Invoke a callable.
 */
interface InvokerInterface
{
    /**
     * Call the given function using the given parameters.
     *
     * @param callable|array|string $callable Function to call.
     * @param array $parameters Parameters to use.
     * @return mixed Result of the function.
     * @throws InvocationException Base exception class for all the sub-exceptions below.
     * @throws NotCallableException
     * @throws NotEnoughParametersException
     */
    public function call($callable, array $parameters = []);
}
