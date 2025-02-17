<?php

declare(strict_types=1);

namespace OWCAD\Http\Handlers;

use OWCAD\Http\Errors\BadRequestError;
use OWCAD\Http\Response;

class BadRequestHandler implements HandlerInterface
{
	/**
	 * @since 0.0.1
	 */
	public function handle( Response $response ): Response
	{
		if ( $response->get_response_code() !== 400 ) {
			return $response;
		}

		throw BadRequestError::from_response( $response );
	}
}
