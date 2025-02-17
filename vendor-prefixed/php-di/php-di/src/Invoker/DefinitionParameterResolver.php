<?php
/**
 * @license MIT
 *
 * Modified by owc on 18-February-2025 using {@see https://github.com/BrianHenryIE/strauss}.
 */

declare(strict_types=1);

namespace OWCAD\Vendor_Prefixed\DI\Invoker;

use OWCAD\Vendor_Prefixed\DI\Definition\Definition;
use OWCAD\Vendor_Prefixed\DI\Definition\Helper\DefinitionHelper;
use OWCAD\Vendor_Prefixed\DI\Definition\Resolver\DefinitionResolver;
use OWCAD\Vendor_Prefixed\Invoker\ParameterResolver\ParameterResolver;
use ReflectionFunctionAbstract;

/**
 * Resolves callable parameters using definitions.
 *
 * @since 5.0
 * @author Matthieu Napoli <matthieu@mnapoli.fr>
 */
class DefinitionParameterResolver implements ParameterResolver
{
    public function __construct(
        private DefinitionResolver $definitionResolver
    ) {
    }

    public function getParameters(
        ReflectionFunctionAbstract $reflection,
        array $providedParameters,
        array $resolvedParameters
    ) : array {
        // Skip parameters already resolved
        if (! empty($resolvedParameters)) {
            $providedParameters = array_diff_key($providedParameters, $resolvedParameters);
        }

        foreach ($providedParameters as $key => $value) {
            if ($value instanceof DefinitionHelper) {
                $value = $value->getDefinition('');
            }

            if (! $value instanceof Definition) {
                continue;
            }

            $value = $this->definitionResolver->resolve($value);

            if (is_int($key)) {
                // Indexed by position
                $resolvedParameters[$key] = $value;
            } else {
                // Indexed by parameter name
                // TODO optimize?
                $reflectionParameters = $reflection->getParameters();
                foreach ($reflectionParameters as $reflectionParameter) {
                    if ($key === $reflectionParameter->name) {
                        $resolvedParameters[$reflectionParameter->getPosition()] = $value;
                    }
                }
            }
        }

        return $resolvedParameters;
    }
}
