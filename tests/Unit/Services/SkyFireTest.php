<?php

namespace Tests\Unit\Services;

use App\Services\SkyFire;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery;
use Tests\TestCase;

class SkyFireTest extends TestCase
{
    /**
     * @test
     */
    public function canCreateAnAccount()
    {
        $client = Mockery::mock(\SoapClient::class);
        $client
            ->shouldReceive('executeCommand')
            ->with(
                Mockery::on(
                    function ($soapParam) {
                        return $soapParam->param_name === 'command'
                        && $soapParam->param_data === 'account create john secret';
                    }
                )
            )
            ->andReturn(['id' => 1]);

        $user = new User(['account_name' => 'john']);

        $this->assertEquals(['id' => 1], (new SkyFire($client))->createAccount($user, 'secret'));
    }

    /**
     * @test
     */
    public function canSendItemsByMailToIngameCharacter()
    {
        $client = Mockery::mock(\SoapClient::class);
        $client
            ->shouldReceive('executeCommand')
            ->with(
                Mockery::on(
                    function ($soapParam) {
                        $subject = trans('ingame_mails.items.subject');
                        $body = trans('ingame_mails.items.body');
                        $itemIdQuantityPair = '1:2';

                        return $soapParam->param_name === 'command'
                        && $soapParam->param_data === "send items john {$subject} {$body} {$itemIdQuantityPair}";
                    }
                )
            )
            ->andReturn();

        $this->assertNull(
            (new SkyFire($client))->sendItems('john', [[1,2]])
        );
    }
}
