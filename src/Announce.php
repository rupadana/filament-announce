<?php

namespace Rupadana\FilamentAnnounce;

use Closure;
use Filament\Notifications\Notification;
use Filament\Support\Concerns\HasAlignment;
use Filament\Support\Enums\Alignment;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Rupadana\FilamentAnnounce\Notifications\AnnounceNotification;

class Announce extends Notification
{
    use HasAlignment;

    protected bool | Closure $closeButton = true;

    protected Alignment | string | Closure | null $titleAlignment = null;

    protected Alignment | string | Closure | null $bodyAlignment = null;

    public function announceTo(Model | Authenticatable | Collection | array $users): void
    {
        if (! $this->getColor()) {
            $this->color(app(FilamentAnnounce::class)->getColor());
        }

        if (! is_iterable($users)) {
            $users = [$users];
        }

        foreach ($users as $user) {
            $notification = new AnnounceNotification($this->getDatabaseMessage());

            $user->notify($notification);
        }
    }

    public function disableCloseButton(bool | Closure $condition = true): static
    {
        $this->closeButton = ! $condition;

        return $this;
    }

    public function titleAlignment(Alignment | string | Closure | null $alignment): static
    {
        $this->titleAlignment = $alignment;

        return $this;
    }

    public function bodyAlignment(Alignment | string | Closure | null $alignment): static
    {
        $this->bodyAlignment = $alignment;

        return $this;
    }

    public function toArray(): array
    {
        return [
            ...parent::toArray(),
            'closeButton' => $this->isClosable(),
            'titleAlignment' => $this->getTitleAlignment(),
            'bodyAlignment' => $this->getBodyAlignment(),
        ];
    }

    public static function fromArray(array $data): static
    {
        $static = parent::fromArray($data);

        $static->disableCloseButton(! $data['closeButton']);
        $static->titleAlignment($data['titleAlignment'] ?? null);
        $static->bodyAlignment($data['bodyAlignment'] ?? null);

        return $static;
    }

    public function isClosable(): bool
    {
        return (bool) $this->evaluate($this->closeButton);
    }

    public function getTitleAlignment()
    {
        return $this->evaluate($this->titleAlignment ?? $this->alignment);
    }

    public function getBodyAlignment()
    {
        return $this->evaluate($this->bodyAlignment ?? $this->alignment);
    }
}
