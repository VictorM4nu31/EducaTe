<?php

namespace App\Notifications;

use App\Models\ExamAttempt;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ExamAnnulled extends Notification
{
    use Queueable;

    protected $attempt;

    /**
     * Create a new notification instance.
     */
    public function __construct(ExamAttempt $attempt)
    {
        $this->attempt = $attempt;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject('Examen Anulado: ' . $this->attempt->user->name)
                    ->line('El alumno ' . $this->attempt->user->name . ' ha salido de la pestaña durante el examen: ' . $this->attempt->exam->title)
                    ->action('Ver Examen', route('teacher.exams.show', $this->attempt->exam_id))
                    ->line('El examen ha sido anulado automáticamente.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'attempt_id' => $this->attempt->id,
            'user_name' => $this->attempt->user->name,
            'exam_title' => $this->attempt->exam->title,
            'message' => 'Examen anulado por pérdida de foco.',
        ];
    }
}
