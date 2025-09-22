<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Button extends Component
{
    public function __construct(
        public string $variant = 'default',
        public string $size = 'default',
        public ?string $type = 'button',
        public bool $disabled = false,
    ) {}

    public function render(): View
    {
        return view('components.button');
    }

    public function getClasses(): string
    {
        $baseClasses = 'inline-flex items-center justify-center gap-2 whitespace-nowrap rounded-md text-sm font-medium ring-offset-background transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-ring focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50';

        $variantClasses = match ($this->variant) {
            'default' => 'bg-primary text-primary-foreground hover:bg-primary/90',
            'destructive' => 'bg-destructive text-destructive-foreground hover:bg-destructive/90',
            'outline' => 'border border-input bg-background hover:bg-accent hover:text-accent-foreground',
            'secondary' => 'bg-secondary text-secondary-foreground hover:bg-secondary/80',
            'ghost' => 'hover:bg-accent hover:text-accent-foreground',
            'link' => 'text-primary underline-offset-4 hover:underline',
            default => 'bg-primary text-primary-foreground hover:bg-primary/90',
        };

        $sizeClasses = match ($this->size) {
            'default' => 'h-10 px-4 py-2',
            'sm' => 'h-9 rounded-md px-3',
            'lg' => 'h-11 rounded-md px-8',
            'icon' => 'h-10 w-10',
            default => 'h-10 px-4 py-2',
        };

        return "{$baseClasses} {$variantClasses} {$sizeClasses}";
    }
}
