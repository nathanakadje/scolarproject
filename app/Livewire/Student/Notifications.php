<?php

namespace App\Livewire\Student;

use Livewire\Component;
use App\Models\Notification;
use Livewire\WithPagination;
use Livewire\Attributes\Layout;

#[Layout('layouts.student-layout')]
class Notifications extends Component
{

    use WithPagination;

    public $showDropdown = false;
    public $filterType = 'all'; // all, unread, read
    public $selectedNotification = null;

    protected $listeners = ['notificationReceived' => '$refresh'];

    public function mount()
    {
        $this->student = auth()->user()->student;
        // dd($this->student);
        if (!$this->student) {
            abort(403, 'Profil étudiant non trouvé');
        }
        // Marquer comme vue (pas lu) les notifications affichées
    }

    public function toggleDropdown()
    {
        $this->showDropdown = !$this->showDropdown;
    }

    public function markAsRead($notificationId)
    {
        $notification = Notification::find($notificationId);

        if ($notification && $notification->notifiable_id === auth()->user()->student->id) {
            $notification->markAsRead();
            $this->dispatch('notification-read');
        }
    }

    public function markAllAsRead()
    {
        Notification::forUser(auth()->user()->student->id)
            ->unread()
            ->update(['read_at' => now()]);

        $this->dispatch('all-notifications-read');
    }

    public function deleteNotification($notificationId)
    {
        $notification = Notification::find($notificationId);

        if ($notification && $notification->notifiable_id === auth()->user()->student->id) {
            $notification->delete();
        }
    }

    public function viewNotification($notificationId)
    {
        $this->markAsRead($notificationId);
        $notification = Notification::find($notificationId);

        if ($notification && $notification->related_type === 'App\\Models\\CalendarEvent') {
            return redirect()->route('student.calendar');
        } elseif ($notification && $notification->related_type === 'App\\Models\\Assignment') {
            return redirect()->route('student.assignments', $notification->related_id);
        }
    }

    public function getUnreadCountProperty()
    {
        return Notification::forUser(auth()->user()->student->id)
            ->unread()
            ->count();
    }

    public function getNotificationsProperty()
    {
        $query = Notification::forUser(auth()->user()->student->id)
            ->orderBy('created_at', 'desc');

        if ($this->filterType === 'unread') {
            $query->unread();
        } elseif ($this->filterType === 'read') {
            $query->read();
        }

        return $query->paginate(15);
    }

    public function render()
    {
        return view('livewire.student.notifications', [
            'notifications' => $this->notifications,
            'unreadCount' => $this->unreadCount,
        ]);
    }
    // public function render()
    // {
    //     return view('livewire.student.notifications');
    // }
}
