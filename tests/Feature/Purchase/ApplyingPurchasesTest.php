<?php

namespace Tests\Feature\Purchase;

use App\Purchase;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ApplyingPurchasesTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function cannotApplyAPurchaseMoreThanOnce()
    {
        $this->actingAs($user = factory(User::class)->states('with skyfire account')->create());

        $purchase = factory(Purchase::class)->states('applied')->create(['user_id' => $user->id]);

        DB::connection('skyfire_characters')->table('characters')->insert([
            'account' => $user->gameAccounts->first()->account_id,
            'guid' => $guid = DB::connection('skyfire_characters')->table('characters')->max('guid') + 1,
            'name' => 'testing',
            'taximask' => 1
        ]);

        $this->json('POST', "/purchases/{$purchase->id}/apply", ['emulator' => 'SkyFire', 'character_id' => $guid])->assertStatus(403);

        DB::connection('skyfire_characters')->table('characters')->where('guid', $guid)->delete();
    }
}
