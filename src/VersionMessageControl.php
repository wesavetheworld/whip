<?php


class VersionMessageControl {

	/**
	 * @var VersionDetector
	 */
	protected $versionDetector;

	/**
	 * @var MessagePresenter[]
	 */
	protected $messagePresenters;

	public function __construct( VersionDetector $versionDetector, array $messagePresenters ) {
		$this->versionDetector = $versionDetector;
		$this->messagePresenters = $messagePresenters;
	}
	/**
	 * Requires a certain version for the given version detector and show a message using the message presenter.
	 *
	 * @param string $version
	 */
	public function requireVersion( $version ) {
		$current_version = $this->versionDetector->detect();
		$versionRelation = version_compare( $current_version, $version );

		if ( ! $this->isStatisfied( $version ) ) {
			$this->showMessage( $this->versionDetector->getMessage() );
		}
	}

	/**
	 * Returns if the given version is statisfied by the installed version
	 *
	 * @param string $required_version The required version.
	 * @returns bool
	 */
	public function isStatisfied( $required_version ) {
		$current_version = $this->versionDetector->detect();

		return version_compare( $current_version, $required_version, ">=" );
	}

	/**
	 * Shows the version message to the user with all messengers.
	 *
	 * @param string $message The message to show to the user.
	 */
	public function showMessage( $message ) {
		foreach ( $this->messagePresenters as $messagePresenter ) {
			$messagePresenter->show( $message );
		}
	}


	/**
	 * Returns the configured version detector
	 *
	 * @return VersionDetector
	 */
	public function getVersionDetector() {
		return $this->versionDetector;
	}

	/**
	 * @param VersionDetector $versionDetector
	 */
	public function setVersionDetector( $versionDetector ) {
		$this->versionDetector = $versionDetector;
	}

	/**
	 * Returns the configured message presenters
	 *
	 * @return MessagePresenter
	 */
	public function getMessagePresenters() {
		return $this->messagePresenters;
	}

	/**
	 * @param MessagePresenter[] $messagePresenters
	 */
	public function setMessagePresenters( $messagePresenters ) {
		$this->messagePresenters = $messagePresenters;
	}
}

