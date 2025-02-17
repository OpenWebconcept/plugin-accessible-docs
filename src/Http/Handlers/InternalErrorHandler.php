<?php

declare(strict_types=1);

namespace OWCAD\Http\Handlers;

use OWCAD\Http\Errors\ServerError;
use OWCAD\Http\Response;

class InternalErrorHandler implements HandlerInterface
{
	/**
	 * @since 0.0.1
	 */
	public function handle( Response $response ): Response
	{
		if ( $response->get_response_code() !== 500 ) {
			return $response;
		}

		throw ServerError::from_response( $response );
	}
}
