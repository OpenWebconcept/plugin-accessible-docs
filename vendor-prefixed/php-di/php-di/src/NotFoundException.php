<?php
/**
 * @license MIT
 *
 * Modified by owc on 18-February-2025 using {@see https://github.com/BrianHenryIE/strauss}.
 */

declare(strict_types=1);

namespace OWCAD\Vendor_Prefixed\DI;

use OWCAD\Vendor_Prefixed\Psr\Container\NotFoundExceptionInterface;

/**
 * Exception thrown when a class or a value is not found in the container.
 */
class NotFoundException extends \Exception implements NotFoundExceptionInterface
{
}
