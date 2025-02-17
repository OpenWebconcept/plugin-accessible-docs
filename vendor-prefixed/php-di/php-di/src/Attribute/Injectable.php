<?php
/**
 * @license MIT
 *
 * Modified by owc on 18-February-2025 using {@see https://github.com/BrianHenryIE/strauss}.
 */

declare(strict_types=1);

namespace OWCAD\Vendor_Prefixed\DI\Attribute;

use Attribute;

/**
 * "Injectable" attribute.
 *
 * Marks a class as injectable
 *
 * @api
 *
 * @author Domenic Muskulus <domenic@muskulus.eu>
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 */
#[Attribute(Attribute::TARGET_CLASS)]
final class Injectable
{
    /**
     * @param bool|null $lazy Should the object be lazy-loaded.
     */
    public function __construct(
        private ?bool $lazy = null,
    ) {
    }

    public function isLazy() : bool|null
    {
        return $this->lazy;
    }
}
