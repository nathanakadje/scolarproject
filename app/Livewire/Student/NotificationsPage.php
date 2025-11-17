<?php

namespace App\Livewire\Student;

use App\Traits\HasToastNotifications;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Notification;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use App\Models\Student;

#[Layout('layouts.student-layout')]
class NotificationsPage extends Component
{
    use WithPagination, HasToastNotifications;

    public string $filterType = 'all';
    public string $filterCategory = 'all';
    public $student;

    public function mount(): void
    {
        $this->student = Student::where('user_id', auth()->id())->first();
        $this->currentDate = today()->format('Y-m-d');
        // dd($this->student);

        if (!$this->student) {
            abort(403, 'Profil étudiant non trouvé');
        }
    }

    public function markAsRead($notificationId): void
    {
        try {
            $notification = Notification::find($notificationId);

            if ($this->isUsersNotification($notification)) {
                $notification->update(['read_at' => now()]);

                // Émettre l'événement Alpine.js
                $this->dispatch('notification-updated', [
                    'count' => $this->student->unreadNotifications()->count()
                ]);

                $this->toastsuccess('Notification marquée comme lue');
            }
        } catch (\Exception $e) {
            $this->toasterror('Erreur lors du marquage comme lu');
        }
    }

    public function markAllAsRead(): void
    {
        try {
            $updatedCount = Notification::forUser($this->student->id)
                ->unread()
                ->update(['read_at' => now()]);
            // Émettre l'événement Alpine.js
            $this->dispatch('notification-updated', [
                'count' => 0
            ]);
            $this->toastsuccess("{$updatedCount} notification(s) marquée(s) comme lue(s)");
        } catch (\Exception $e) {
            $this->toasterror('Erreur lors du marquage global');
        }
    }

    public function deleteNotification($notificationId): void
    {
        try {
            $notification = Notification::find($notificationId);
            if ($notification && $this->isUsersNotification($notification)) {
                $wasUnread = is_null($notification->read_at);
                $notification->delete();

                if ($wasUnread) {
                    // Émettre l'événement seulement si la notification était non lue
                    $this->dispatch('notification-updated', [
                        'count' => $this->student->unreadNotifications()->count()
                    ]);
                }
                // if ($this->isUsersNotification($notification)) {
                //     $notification->delete();
                //     if ($wasUnread) {
                //     // Émettre l'événement seulement si la notification était non lue
                //     $this->dispatchBrowserEvent('notification-updated', [
                //         'count' => $this->student->unreadNotifications()->count()
                //     ]);
                // }
                $this->toastsuccess('Notification supprimée');
            }
        } catch (\Exception $e) {
            $this->toasterror('Erreur lors de la suppression');
        }
    }

    // public function deleteAllRead(): void
    // {
    //     try {
    //         $deletedCount = Notification::forUser($this->student->id)
    //             ->read()
    //             ->delete();

    //         $this->toastsuccess("{$deletedCount} notification(s) supprimée(s)");
    //     } catch (\Exception $e) {
    //         $this->toasterror('Erreur lors de la suppression globale');
    //     }
    // }

    public function deleteAllRead()
    {
        // Compter combien étaient non lues avant suppression
        $unreadCount = $this->student->unreadNotifications()->count();

        $this->student->notifications()
            ->whereNotNull('read_at')
            ->delete();

        // Si des notifications non lues existaient, émettre l'événement
        if ($unreadCount > 0) {
            $this->dispatch('notification-updated', [
                'count' => $unreadCount
            ]);
        }
    }

    private function isUsersNotification(?Notification $notification): bool
    {
        return $notification &&
            $notification->notifiable_type === 'App\Models\Student' &&
            $notification->notifiable_id === $this->student->id;
    }

    #[Computed]
    public function notifications()
    {
        $query = Notification::forUser($this->student->id)
            ->orderBy('created_at', 'desc');

        if ($this->filterType === 'unread') {
            $query->unread();
        } elseif ($this->filterType === 'read') {
            $query->read();
        }

        if ($this->filterCategory !== 'all') {
            $query->where('type', $this->filterCategory);
        }

        return $query->paginate(20);
    }

    #[Computed]
    public function stats(): array
    {
        return [
            'total' => Notification::forUser($this->student->id)->count(),
            'unread' => Notification::forUser($this->student->id)->unread()->count(),
            'today' => Notification::forUser($this->student->id)
                ->whereDate('created_at', today())->count(),
        ];
    }

    public function render()
    {
        return view('livewire.student.notifications', [
            'notifications' => $this->notifications,
            'stats' => $this->stats,
        ]);
    }
}