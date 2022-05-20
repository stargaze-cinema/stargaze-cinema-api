<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class MailerService
{
    private const SUPPORT_ADDRESS = 'support@stargaze.com';

    public function __construct(
        private MailerInterface $mailer
    ) {
    }

    private function compose(string $from, array $to, string $subject, string $template, array $context): void
    {
        $email = (new TemplatedEmail())
            ->from(new Address($from, 'Stargaze Cinema'))
            ->to(new Address($to[0], $to[1]))
            ->subject($subject)
            ->htmlTemplate($template)
            ->context($context);

        $this->mailer->send($email);
    }

    public function composeTicket(array $context): void
    {
        $this->compose(
            from: self::SUPPORT_ADDRESS,
            to: [$context['user']->getEmail(), $context['user']->getName()],
            subject: 'Your ticket for '.$context['movie']->getTitle(),
            template: 'emails/ticket.html.twig',
            context: $context
        );
    }
}
