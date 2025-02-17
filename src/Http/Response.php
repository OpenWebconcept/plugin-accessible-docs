<?php

declare(strict_types=1);

namespace OWCAD\Http;

class Response
{
	protected array $headers;
	protected string $requested_url;
	protected array $response;
	protected string $body;
	protected array $json;

	public function __construct( array $headers, string $requested_url, array $response, string $body )
	{
		$this->headers       = $headers;
		$this->requested_url = $requested_url;
		$this->response      = $response;
		$this->body          = $body;
		$this->json          = $this->parse_as_json( $this->body );
	}

	/**
	 * @since 0.0.1
	 */
	public function get_headers(): array
	{
		return $this->headers;
	}

	/**
	 * @since 0.0.1
	 */
	public function get_requested_url(): string
	{
		return $this->requested_url;
	}

	/**
	 * @since 0.0.1
	 */
	public function get_response(): array
	{
		return $this->response;
	}

	/**
	 * @since 0.0.1
	 */
	public function get_response_code(): ?int
	{
		return $this->response['code'] ?? null;
	}

	/**
	 * @since 0.0.1
	 */
	public function get_response_message(): ?string
	{
		return $this->response['message'] ?? null;
	}

	/**
	 * @since 0.0.1
	 */
	public function get_body(): string
	{
		return $this->body;
	}

	/**
	 * @since 0.0.1
	 */
	public function get_parsed_json(): array
	{
		return $this->json;
	}

	/**
	 * @since 0.0.1
	 */
	protected function parse_as_json( string $body ): array
	{
		$decoded = json_decode( $body, true, 512 );

		if ( ! is_array( $decoded ) ) {
			return array();
		}

		return $decoded;
	}
}
