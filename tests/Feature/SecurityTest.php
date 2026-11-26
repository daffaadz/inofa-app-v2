<?php

namespace Tests\Feature;

use App\Events\PaymentStatusUpdated;
use App\Models\ChMessage;
use App\Models\Payment;
use App\Models\Project;
use App\Models\ProjectAgreement;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Tests\TestCase;

class SecurityTest extends TestCase
{
    use RefreshDatabase;

    private function user(string $role, array $attributes = []): User
    {
        return User::factory()->create(['role' => $role] + $attributes);
    }

    private function project(User $consumer, string $title = 'Proyek'): Project
    {
        return Project::create([
            'consumer_id' => $consumer->id, 'title' => $title, 'description' => 'd',
            'budget' => 100, 'deadline' => now()->addMonth(), 'status' => 'open',
        ]);
    }

    private function agreement(User $consumer, User $developer, string $title = 'Proyek', string $status = 'pending'): ProjectAgreement
    {
        return ProjectAgreement::create([
            'project_title' => $title, 'consumer_id' => $consumer->id, 'developer_id' => $developer->id,
            'final_price' => 100, 'status' => $status,
        ]);
    }

    public function test_public_registration_cannot_create_admin(): void
    {
        $form = ['name' => 'X', 'email' => 'x@example.com', 'password' => 'password', 'password_confirmation' => 'password'];

        $this->post('/register', $form + ['role' => 'admin'])->assertSessionHasErrors('role');
        $this->assertDatabaseMissing('users', ['email' => 'x@example.com']);

        $this->post('/register', $form + ['role' => 'developer'])->assertSessionHasNoErrors();
        $this->assertDatabaseHas('users', ['email' => 'x@example.com', 'role' => 'developer']);
    }

    public function test_role_can_be_chosen_by_new_user_but_not_after_activity(): void
    {
        $user = $this->user('consumer');
        $this->actingAs($user)->post('/select-role', ['role' => 'developer'])->assertRedirect();
        $this->assertSame('developer', $user->fresh()->role);

        $busy = $this->user('consumer');
        $this->project($busy);
        $this->actingAs($busy)->post('/select-role', ['role' => 'developer'])->assertForbidden();
    }

    public function test_unknown_social_driver_is_not_found(): void
    {
        $this->get('/auth/unknown')->assertNotFound();
    }

    public function test_chat_channels_of_other_users_are_private(): void
    {
        [$me, $other] = [$this->user('consumer'), $this->user('developer')];
        $auth = fn (string $channel) => $this->actingAs($me)
            ->post('/chatify/chat/auth', ['channel_name' => $channel, 'socket_id' => '1.1']);

        $auth("private-chatify.{$other->id}")->assertForbidden();
        $auth('private-conversation.1')->assertForbidden();
        $auth("private-chatify.{$me->id}")->assertOk()->assertSee('auth');
        $auth("private-chatify-signal.{$other->id}")->assertOk()->assertSee('auth');
    }

    public function test_chat_info_does_not_expose_email(): void
    {
        $other = $this->user('developer');

        $this->actingAs($this->user('consumer'))->post('/chatify/idInfo', ['id' => $other->id])
            ->assertOk()
            ->assertJsonPath('fetch.name', $other->name)
            ->assertDontSee($other->email);
    }

    public function test_chat_bodies_escape_user_supplied_names(): void
    {
        $xss = '<img src=x onerror=1>';
        $consumer = $this->user('consumer');
        $developer = $this->user('developer', ['name' => $xss]);
        $project = $this->project($consumer, $xss);

        $this->actingAs($developer)->post("/projects/{$project->id}/quick-apply")->assertOk();
        $this->actingAs($developer)->post("/projects/{$project->id}/quick-apply")->assertStatus(400);

        $agreement = $this->agreement($consumer, $developer, $xss, 'active');
        $this->actingAs($consumer)->post("/consumer/agreements/{$agreement->id}/stop")->assertSessionHas('success');

        $this->assertSame(2, ChMessage::count());
        ChMessage::all()->each(fn ($m) => $this->assertStringNotContainsString('<img', $m->body));
    }

    public function test_consumer_can_reject_a_proposal_with_message(): void
    {
        [$consumer, $developer] = [$this->user('consumer'), $this->user('developer')];
        $agreement = $this->agreement($consumer, $developer);
        $message = ChMessage::create([
            'from_id' => $developer->id, 'to_id' => $consumer->id,
            'project_agreement_id' => $agreement->id, 'metadata' => ['status' => 'pending'],
        ]);

        $this->actingAs($this->user('consumer'))->post("/proposals/{$agreement->id}/reject")->assertStatus(400);
        $this->actingAs($consumer)->post("/proposals/{$agreement->id}/reject")->assertOk();
        $this->assertSame('terminated', $agreement->fresh()->status);
        $this->assertSame('rejected', $message->fresh()->metadata['status']);
    }

    public function test_conversation_topic_cannot_reveal_other_consumers_project(): void
    {
        [$consumer, $developer] = [$this->user('consumer'), $this->user('developer')];
        $secret = $this->project($this->user('consumer'), 'Rahasia');
        $conversation = \App\Models\Conversation::create(['type' => 'project', 'title' => 't']);
        $conversation->participants()->attach([$consumer->id, $developer->id]);

        $this->actingAs($consumer)
            ->post("/chatify/update-project-topic/{$conversation->id}", ['project_id' => $secret->id])
            ->assertNotFound()->assertDontSee('Rahasia');
    }

    public function test_paid_out_payments_cannot_be_reopened_or_approved_again(): void
    {
        Event::fake([PaymentStatusUpdated::class]);
        $agreement = $this->agreement($this->user('consumer'), $this->user('developer'));
        $payment = Payment::create(['project_agreement_id' => $agreement->id, 'amount' => 100, 'status' => 'confirmed']);
        $admin = $this->user('admin');

        $this->actingAs($admin)->post("/admin/payments/{$payment->id}/transfer")->assertOk();
        $this->assertTrue($payment->fresh()->admin_transferred);
        $this->actingAs($admin)->post("/admin/payments/{$payment->id}/review")->assertStatus(400);

        $payment->update(['status' => 'refunded']);
        $this->actingAs($admin)->post("/admin/payments/{$payment->id}/approve")->assertStatus(400);
        $this->actingAs($this->user('consumer'))->post("/admin/payments/{$payment->id}/approve")->assertForbidden();
    }

    public function test_portfolio_update_route_works_for_owner_only(): void
    {
        $owner = $this->user('developer');
        $item = $owner->portfolios()->create(['title' => 'A', 'description' => 'd']);
        $data = ['title' => 'B', 'description' => 'd', 'technologies' => 'PHP, Vue'];

        $this->actingAs($this->user('developer'))->patch("/profile/portfolios/{$item->id}", $data)->assertForbidden();
        $this->actingAs($owner)->patch("/profile/portfolios/{$item->id}", $data)->assertSessionHasNoErrors();
        $this->assertSame(['PHP', 'Vue'], $item->fresh()->technologies);
    }
}
