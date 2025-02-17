<?php

declare(strict_types=1);

namespace OWCAD\Http;

use Exception;
use OWCAD\Http\Handlers\Stack;
use OWCAD\Singletons\SiteOptionsSingleton;
use OWCAD\Traits\ErrorLog;

class Request
{
	use ErrorLog;

	public const ENDPOINT = '';

	protected SiteOptionsSingleton $options;
	protected Stack $response_handlers;
	protected string $boundary;
	protected string $content_type = 'application/json';
	protected bool $is_ndjson      = false;

	public function __construct()
	{
		$this->options           = owcad_resolve_from_container( 'owcad.site_options' );
		$this->response_handlers = Stack::create();
		$this->boundary          = sprintf( '----WebKitFormBoundary%s', wp_generate_uuid4() );
	}

	/**
	 * @since 0.0.1
	 */
	public function set_content_type( string $type ): self
	{
		$this->content_type = $type;

		return $this;
	}

	/**
	 * @since 0.0.1
	 */
	public function set_is_ndjson( bool $is_ndjson ): self
	{
		$this->is_ndjson = $is_ndjson;

		return $this;
	}

	/**
	 * @since 0.0.1
	 */
	public function get(): array
	{
		return $this->request( 'GET' );
	}

	/**
	 * @since 0.0.1
	 */
	public function post( array $args = array() ): array
	{
		return $this->request( 'POST', $args );
	}

	/**
	 * @since 0.0.1
	 */
	public function delete( array $args = array() ): array
	{
		return $this->request( 'DELETE', $args );
	}

	/**
	 * @since 0.0.1
	 */
	protected function request( string $method = 'GET', array $args = array() ): array
	{
		try {
			$response = $this->do_request( $method, $args );
		} catch ( Exception $exception ) {
			$this->log_error( $exception->getMessage() );

			return array();
		}

		return $response->get_parsed_json();
	}

	/**
	 * @since 0.0.1
	 *
	 * @throws Exception
	 */
	protected function do_request( string $method = 'GET', array $args = array() ): Response
	{
		$request_args = array(
			'timeout' => 60,
			'method'  => $method,
			'headers' => $this->get_request_headers(),
		);

		if ( ! empty( $args ) ) {
			$request_args['body'] = 'multipart/form-data' === $this->content_type && isset( $args['file'] ) ? $this->generate_multipart_data( $args['file'] ) : json_encode( $args );
		}

		$response = wp_remote_request( $this->make_url(), $request_args );

		if ( is_wp_error( $response ) ) {
			throw new Exception( $response->get_error_message(), 400 );
		}

		$response = new Response(
			isset( $response['headers'] ) ? $response['headers']->getAll() : array(),
			$this->make_url(),
			$response['response'],
			$this->is_ndjson ? $this->handle_ndjson( $response ) : $response['body']
		);

		return $this->handle_response( $response );
	}

	/**
	 * @since 0.0.1
	 *
	 * @throws Exception
	 */
	protected function handle_ndjson( array $response ): string
	{
		$lines = explode( "\n", $response['body'] );

		foreach ( $lines as $line ) {
			if ( ! $line ) {
				continue;
			}

			$event = json_decode( $line, true );

			if ( ! isset( $event['status'] ) || 'done' !== $event['status'] ) {
				continue;
			}

			return json_encode( $event['data'] );
		}

		throw new Exception( 'No converted document returned', 400 );
	}

	/**
	 * @since 0.0.1
	 */
	protected function generate_multipart_data( string $file ): string
	{
		if ( ! file_exists( $file ) ) {
			throw new Exception( sprintf( 'File does not exist: %s', $file ), 500 );
		}

		$EOL = "\r\n"; // For clarity.

		$payload  = '';
		$payload .= '--' . $this->boundary . $EOL;
		$payload .= sprintf( 'Content-Disposition: form-data; name="file"; filename="%s"', basename( $file ) );
		$payload .= $EOL;
		$payload .= sprintf( 'Content-Type: %s', mime_content_type( $file ) );
		$payload .= $EOL . $EOL;
		$payload .= file_get_contents( $file );
		$payload .= $EOL;
		$payload .= '--' . $this->boundary . '--';

		return $payload;
	}

	/**
	 * @since 0.0.1
	 */
	protected function get_request_headers(): array
	{
		return array(
			'Content-Type' => 'multipart/form-data' === $this->content_type ? sprintf( 'multipart/form-data; boundary=%s', $this->boundary ) : $this->content_type,
		);
	}

	/**
	 * @since 0.0.1
	 */
	protected function make_url(): string
	{
		return sprintf( '%s/%s', untrailingslashit( $this->options->api_base_url() ), static::ENDPOINT );
	}

	/**
	 * @since 0.0.1
	 */
	protected function handle_response( Response $response ): Response
	{
		foreach ( $this->response_handlers->get() as $handler ) {
			$response = $handler->handle( $response );
		}

		return $response;
	}
}
