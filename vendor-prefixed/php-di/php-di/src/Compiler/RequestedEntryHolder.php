<?php
/**
 * @license MIT
 *
 * Modified by owc on 18-February-2025 using {@see https://github.com/BrianHenryIE/strauss}.
 */

declare(strict_types=1);

namespace OWCAD\Vendor_Prefixed\DI\Compiler;

use OWCAD\Vendor_Prefixed\DI\Factory\RequestedEntry;

/**
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 */
class RequestedEntryHolder implements RequestedEntry
{
    public function __construct(
        private string $name,
    ) {
    }

    public function getName() : string
    {
        return $this->name;
    }
}
