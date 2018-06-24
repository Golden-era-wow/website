<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\SyncSearchToAlgolia;
use Tests\WithoutSearchIndexing;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, WithoutSearchIndexing;

    /**
     * Boot the testing helper traits.
     *
     * @return array
     */
    protected function setUpTraits()
    {
    	$uses = parent::setUpTraits();

    	if (isset($uses[WithoutSearchIndexing::class])) {
    		$this->disableSearchIndexingForAllTests();
    	}

    	if (isset($uses[SyncSearchToAlgolia::class])) {
    		$this->syncSearchToAlgolia();
    	}
    }
}
