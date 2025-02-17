<?php

namespace OWCAD\Controllers;

use Exception;
use OWCAD\Http\Endpoints\AttachmentForConversion;
use OWCAD\Http\Endpoints\ConvertUplodedAttachment;
use OWCAD\Traits\ErrorLog;

class AttachmentController
{
	use ErrorLog;

	private const ALLOWED_FILE_TYPES = array( 'pdf', 'doc', 'docx' );

	/**
	 * @since 0.0.1
	 */
	public function handle( int $post_id )
	{
		$file_path = $this->validate_file_path( $post_id );

		if ( ! is_string( $file_path ) ) {
			$this->log_error( sprintf( 'AttachmentController: Could not find file path for post ID %d.', $post_id ) );

			return;
		}

		if ( ! $this->validate_file_type( $file_path ) ) {
			$this->log_error( sprintf( 'AttachmentController: File type not allowed for post ID %d.', $post_id ) );

			return;
		}

		try {
			$response_id      = $this->handle_attachment_for_conversion( $file_path, $post_id );
			$convert_response = $this->handle_attachment_conversion( $response_id, $post_id );
			$new_post_id      = $this->handle_post_creation_accessible_document( $convert_response, $post_id );
		} catch ( Exception $exception ) {
			$this->log_error( $exception->getMessage() );
		}
	}

	/**
	 * @since 0.0.1
	 */
	private function validate_file_path( int $post_id ): ?string
	{
		$file_path = get_attached_file( $post_id );

		return is_string( $file_path ) && file_exists( $file_path ) ? $file_path : null;
	}

	/**
	 * @since 0.0.1
	 */
	private function validate_file_type( string $file_path ): bool
	{
		$file_type = wp_check_filetype( $file_path );

		return in_array( $file_type['ext'], self::ALLOWED_FILE_TYPES );
	}

	/**
	 * Upload a document to schedule it for conversion.
	 *
	 * @since 0.0.1
	 *
	 * @throws Exception
	 */
	private function handle_attachment_for_conversion( string $file_path, int $post_id ): string
	{
		$response = ( new AttachmentForConversion() )->set_content_type( 'multipart/form-data' )->post(
			array(
				'file' => $file_path,
			)
		);

		$response_id = $response['data']['id'] ?? '';

		if ( ! is_string( $response_id ) || 1 > strlen( $response_id ) ) {
			throw new Exception( sprintf( 'AttachmentController: Could not find response ID for post ID %d.', $post_id ) );
		}

		return $response_id;
	}

	/**
	 * Starts conversion of a given document resource and returns a stream of events. The stream is closed when the document conversion is finished.
	 *
	 * @since 0.0.1
	 *
	 * @throws Exception
	 */
	private function handle_attachment_conversion( string $response_id, int $post_id ): array
	{
		$convert_response = ( new ConvertUplodedAttachment() )->set_is_ndjson( true )->post(
			array(
				'id'        => $response_id,
				'convertTo' => 'application/vnd.nldoc.gutenberg+json',
			)
		);

		if ( ! is_array( $convert_response ) || ! count( $convert_response ) ) {
			throw new Exception( sprintf( 'AttachmentController: Could not find response of requested conversion for post ID %d.', $post_id ) );
		}

		$post_name = $convert_response['title'] ?? '';

		if ( ! is_string( $post_name ) || 1 > strlen( $post_name ) ) {
			throw new Exception( sprintf( 'AttachmentController: Could not find post name after conversion of attachment with post ID %d.', $post_id ) );
		}

		$blocks = $convert_response['blocks'] ?? array();

		if ( ! is_array( $blocks ) || ! count( $blocks ) ) {
			throw new Exception( sprintf( 'AttachmentController: Could not find converted blocks after conversion of attachment with post ID %d.', $post_id ) );
		}

		return $convert_response;
	}

	/**
	 * Create new post so it can be validated inside the editor after an update which will result in a
	 * fully accessible document after corrections based on feedback provided by NLDoc.
	 *
	 * @since 0.0.1
	 *
	 * @throws Exception
	 */
	private function handle_post_creation_accessible_document( array $convert_response, int $post_id ): int
	{
		$new_post_id = wp_insert_post(
			array(
				'post_title'   => $convert_response['title'],
				'post_content' => serialize_blocks( $convert_response['blocks'] ),
				'post_status'  => 'draft',
				'post_type'    => 'page',
				'meta_input'   => array(
					'owcad_nldoc_document_id' => $convert_response['id'],
				),
			)
		);

		if ( ! is_int( $new_post_id ) || 0 >= $new_post_id ) {
			throw new Exception( sprintf( 'AttachmentController: Could not create new post for converted attachment with post ID %d.', $post_id ) );
		}

		return $new_post_id;
	}
}
