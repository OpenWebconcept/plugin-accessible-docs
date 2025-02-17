<?php

namespace OWCAD\Providers;

use OWCAD\Contracts\ServiceProviderInterface;
use OWCAD\Controllers\AttachmentController;

class AttachmentUploadServiceProvider implements ServiceProviderInterface
{
	/**
	 * @since 0.0.1
	 */
	public function register(): void
	{
		add_action( 'add_attachment', array( new AttachmentController(), 'handle' ), 999 );
	}
}
