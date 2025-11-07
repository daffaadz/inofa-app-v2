<?php

namespace App\Listeners;

use App\Events\OfferCreated;
use App\Models\Conversation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class CreateConversationForOffer implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Buat/temukan conversation project & attach client + developer.
     */
    public function handle(OfferCreated $e): void
    {
        $offer = $e->offer;

        DB::transaction(function () use ($offer) {
            // Cari conversation project yang masih aktif, kalau tidak ada buat baru
            $conv = Conversation::where('type', 'project')
                ->where('project_id', $offer->project_id)
                ->where('is_active', true)
                ->first();

            if (! $conv) {
                $conv = Conversation::create([
                    'type'            => 'project',
                    'project_id'      => $offer->project_id,
                    'title'           => 'Project #'.$offer->project_id,
                    'metadata'        => ['offer_id' => $offer->id],
                    'last_message_at' => now(),
                    'is_active'       => true,
                ]);
            }

            // Attach 2 peserta (tanpa menduplikasi)
            $conv->participants()->syncWithoutDetaching([
                $offer->client_id    => ['role' => 'admin',       'joined_at' => now(), 'is_active' => true],
                $offer->developer_id => ['role' => 'participant', 'joined_at' => now(), 'is_active' => true],
            ]);

            // Simpan referensi ke offer
            if (! $offer->conversation_id) {
                $offer->update(['conversation_id' => $conv->id]);
            }
        });
    }
}
