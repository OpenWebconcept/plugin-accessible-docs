<?php

declare(strict_types=1);

namespace OWCAD\Http\Handlers;

use OWCAD\Http\Errors\ResourceNotFoundError;
use OWCAD\Http\Response;

class ResourceNotFoundHandler implements HandlerInterface
{
	/**
	 * @since 0.0.1
	 */
	public function handle( Response $response ): Response
	{
		if ( $response->get_response_code() !== 404 ) {
			return $response;
		}

		throw ResourceNotFoundError::from_response( $response );
	}
}
