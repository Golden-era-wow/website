<?php

namespace Tests;

trait SyncSearchToAlgolia
{
	public function syncSearchToAlgolia()
	{
		$this->app['config']->set('scout.driver', 'algolia');
	}
}