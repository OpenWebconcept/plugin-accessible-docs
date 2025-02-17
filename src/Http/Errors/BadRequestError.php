<?php

declare(strict_types=1);

namespace OWCAD\Http\Errors;

use OWCAD\Http\RequestError;
use OWCAD\Http\Response;

class BadRequestError extends RequestError
{
	protected array $invalid_parameters = array();

	/**
	 * @since 0.0.1
	 */
	public static function from_response( Response $response )
	{
		$error = parent::from_response( $response );

		if ( 0 === $error->code ) {
			// Unhandable error.
			return $error;
		}

		$json = $response->get_parsed_json();

		$error->set_invalid_parameters( $json['invalidParams'] ?? array() );

		return $error;
	}

	/**
	 * @since 0.0.1
	 */
	public function set_invalid_parameters( array $parameters )
	{
		$this->invalid_parameters = $parameters;

		return $this;
	}

	/**
	 * @since 0.0.1
	 */
	public function get_invalid_parameters(): array
	{
		return $this->invalid_parameters;
	}

	/**
	 * @since 0.0.1
	 */
	public function has_invalid_parameters(): bool
	{
		return ! empty( $this->invalid_parameters );
	}
}
