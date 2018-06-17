<?php

namespace App\Session;


class Flash
{
	protected $session;
	protected $messages;

	public function __construct(SessionInterface $session)
	{
		$this->session = $session;

		$this->loadFlashMessagesIntoCache();

		$this->clear();
	}

	public function now($key, $value)
	{
		$this->session->set('flash', array_merge(
			$this->session->get('flash') ?? [],
			[$key => $value]
		));
	}

	public function get($key)
	{
		return $this->messages[$key]??null;
	}

	public function getAll()
	{
		return $this->session->get('flash');
	}

	protected function loadFlashMessagesIntoCache()
	{
		$this->messages = $this->getAll();
	}

	protected function clear()
	{
		$this->session->clear('flash');
	}
}