<?php

declare(strict_types=1);

namespace OWCAD\Http;

use Exception;
use Throwable;

class RequestError extends Exception
{
	protected ?Response $response = null;

	/**
	 * @since 0.0.1
	 */
	public static function from_response( Response $response )
	{
		try {
			$json    = $response->get_parsed_json();
			$message = sprintf( 'Something went wrong while requesting %s. Error: %s', $response->get_requested_url(), $json['message'] ?? 'No error message could be retrieved.' );
			$status  = $response->get_response_code();
		} catch ( Throwable $e ) {
			$message = 'A request error occurred. Additionally, no error message could be retrieved.';
			$status  = 0;
		}

		$error = new static( $message, $status );
		$error->set_response( $response );

		return $error;
	}

	/**
	 * @since 0.0.1
	 */
	public function set_response( Response $response ): self
	{
		$this->response = $response;

		return $this;
	}

	/**
	 * @since 0.0.1
	 */
	public function get_response(): ?Response
	{
		return $this->response;
	}
}
