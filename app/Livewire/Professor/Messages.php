<?php

namespace App\Livewire\Student;

use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.professor-layout')]
class Messages extends Component
{
    public $conversations = [];
    public $selectedConversation = null;
    public $messages = [];
    public $newMessage = '';
    public $searchQuery = '';

    public function mount()
    {
        // Simuler des conversations
        $this->conversations = [
            [
                'id' => 1,
                'professor' => 'Dr. Kouame',
                'subject' => 'Mathématiques',
                'last_message' => 'N\'oubliez pas le devoir pour lundi',
                'time' => '2h',
                'unread' => 2,
                'avatar_color' => 'blue'
            ],
            [
                'id' => 2,
                'professor' => 'Prof. Diallo',
                'subject' => 'Physique',
                'last_message' => 'Les résultats du TP sont disponibles',
                'time' => '5h',
                'unread' => 0,
                'avatar_color' => 'green'
            ],
            [
                'id' => 3,
                'professor' => 'Mme. Traore',
                'subject' => 'Anglais',
                'last_message' => 'Excellent travail sur la présentation',
                'time' => '1j',
                'unread' => 1,
                'avatar_color' => 'purple'
            ],
        ];

        if (count($this->conversations) > 0) {
            $this->selectConversation($this->conversations[0]['id']);
        }
    }

    public function selectConversation($conversationId)
    {
        $this->selectedConversation = collect($this->conversations)
            ->firstWhere('id', $conversationId);

        // Simuler des messages
        $this->messages = [
            [
                'id' => 1,
                'sender' => 'professor',
                'content' => 'Bonjour, j\'ai remarqué que vous n\'avez pas rendu le dernier devoir. Y a-t-il un problème ?',
                'time' => '2025-10-06 10:30',
            ],
            [
                'id' => 2,
                'sender' => 'student',
                'content' => 'Bonjour Professeur, je suis désolé. J\'ai eu quelques problèmes avec l\'exercice 3.',
                'time' => '2025-10-06 11:15',
            ],
            [
                'id' => 3,
                'sender' => 'professor',
                'content' => 'Je comprends. Pouvez-vous passer me voir après le cours demain ? Je vous expliquerai.',
                'time' => '2025-10-06 11:20',
            ],
            [
                'id' => 4,
                'sender' => 'student',
                'content' => 'Merci beaucoup ! Je serai là demain.',
                'time' => '2025-10-06 11:25',
            ],
        ];
    }

    public function sendMessage()
    {
        if (trim($this->newMessage) === '') {
            return;
        }

        // Ajouter le message (logique à implémenter)
        $this->messages[] = [
            'id' => count($this->messages) + 1,
            'sender' => 'student',
            'content' => $this->newMessage,
            'time' => now()->format('Y-m-d H:i'),
        ];

        $this->newMessage = '';
    }

    public function render()
    {
        return view('livewire.professor.messages');
    }
}