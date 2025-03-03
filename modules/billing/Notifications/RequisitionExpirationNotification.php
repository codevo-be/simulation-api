<?php
namespace Diji\Billing\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RequisitionExpirationNotification extends Notification
{
    use Queueable;

    protected $daysLeft;
    protected $link;

    /**
     * Create a new notification instance.
     */
    public function __construct($daysLeft, $link)
    {
        $this->daysLeft = $daysLeft;
        $this->link = $link;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $subject = $this->daysLeft <= 0
            ? "🔴 Votre accès bancaire a expiré !"
            : "⏳ Votre connexion bancaire expire dans {$this->daysLeft} jours";

        return (new MailMessage)
            ->subject($subject)
            ->greeting("Bonjour,")
            ->line("Votre connexion bancaire avec Gocardless expire dans **{$this->daysLeft} jours**.")
            ->line("Pour continuer à utiliser ce service, veuillez renouveler votre connexion bancaire.")
            ->action('Renouveler ma connexion', $this->link)
            ->line('Merci de votre confiance !');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
