<?php

namespace ICodeWP\KernelTrait;

use ICodeWP\Service\Assets;
use ICodeWP\Service\Template;
use ICodeWP\Service\UserMessages;

/**
 * Loads and provides basic services.
 */
trait Services {
	public function assets(): Assets {
		static $assets;
		return $assets ??= new Assets(
			$this->path() . '/assets',
			$this->url() . '/assets',
			$this->version()
		);
	}

	public function template(): Template {
		static $template;
		return $template ??= new Template( $this->path() . 'templates/' );
	}

	public function user_messages(): UserMessages {
		static $user_messages;
		return $user_messages ??= new UserMessages( $this->prefix() . 'user_messages' );
	}
}
