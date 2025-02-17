<?php

declare(strict_types=1);

namespace OWCAD\Http\Handlers;

use OWCAD\Http\Errors\UnauthenticatedError;
use OWCAD\Http\Response;

class UnauthenticatedHandler implements HandlerInterface
{
	/**
	 * @since 0.0.1
	 */
	public function handle( Response $response ): Response
	{
		if ( ! in_array( $response->get_response_code(), array( 401, 403 ) ) ) {
			return $response;
		}

		throw UnauthenticatedError::from_response( $response );
	}
}
