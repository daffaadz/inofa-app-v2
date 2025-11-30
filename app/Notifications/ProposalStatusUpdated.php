<?php

namespace App\Notifications;

use App\Models\ProjectAgreement;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class ProposalStatusUpdated extends Notification implements ShouldBroadcast
{
    use Queueable;

    public $agreement;
    public $status;
    public $updatedBy;

    public function __construct(ProjectAgreement $agreement, $updatedBy)
    {
        $this->agreement = $agreement;
        $this->status = $agreement->status;
        $this->updatedBy = $updatedBy;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'agreement_id' => $this->agreement->id,
            'status' => $this->status,
            'project_title' => $this->agreement->project_title,
            'updated_by' => [
                'id' => $this->updatedBy->id,
                'name' => $this->updatedBy->name,
            ],
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'type' => 'App\\Notifications\\ProposalStatusUpdated',
            'agreement_id' => $this->agreement->id,
            'status' => $this->status,
            'project_title' => $this->agreement->project_title,
        ]);
    }

    public function broadcastOn()
    {
        // Broadcast to the user receiving the notification (developer in this case)
        return [new \Illuminate\Broadcasting\PrivateChannel('App.Models.User.' . $this->agreement->developer_id)];
    }

    public function broadcastAs()
    {
        return 'proposal.status.updated';
    }
}
