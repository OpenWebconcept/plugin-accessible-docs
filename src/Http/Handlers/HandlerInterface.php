<?php

declare(strict_types=1);

namespace OWCAD\Http\Handlers;

use OWCAD\Http\Response;

interface HandlerInterface
{
	public function handle( Response $response ): Response;
}
