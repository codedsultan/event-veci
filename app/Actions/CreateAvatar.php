<?php

namespace App\Actions;

use Lorisleiva\Actions\Concerns\AsAction;

class CreateAvatar
{
    use AsAction;

    public function handle(
        $name,
        $email = null,
        $bgColor = null,
        $color = null,
        $style = 'initials',
    ): string {
        $encodedName = urlencode(ucfirst($name));

        if ($bgColor === null) {
            $bgColor = substr($this->getColors($encodedName)['bgColor'], 1);
        }

        if ($color === null) {
            $color = substr($this->getColors($encodedName)['color'], 1);
        }

        $avatar = "https://api.dicebear.com/6.x/$style/svg?seed=$name&backgroundColor=$bgColor&color=$color";

        if ($style === 'initials') {
            $avatar = "https://ui-avatars.com/api/?name=$encodedName&background=$bgColor&color=$color";
        }

        if ($style === 'lorelei') {
            $avatar .= '&width=100&height=100mouth=happy01,happy02,happy03&frecklesProbability=32&glassesProbability=32';
        }

        //        if (null !== $email) {
        //            $md5email = strtolower(trim(md5($email)));
        //
        //            $avatar = urlencode($avatar);
        //
        //            $avatar = "https://www.gravatar.com/avatar/$md5email?d=$avatar";
        //        }

        return $avatar;
    }

    private function getColors($name): array
    {
        $colors = [
            [
                'bgColor' => '#f1f5f9',
                'color' => '#64748b',
            ],
            [
                'bgColor' => '#f3f4f6',
                'color' => '#6b7280',
            ],
            [
                'bgColor' => '#f4f4f5',
                'color' => '#71717a',
            ],
            [
                'bgColor' => '#f5f5f5',
                'color' => '#737373',
            ],
            [
                'bgColor' => '#f5f5f4',
                'color' => '#78716c',
            ],
            [
                'bgColor' => '#fee2e2',
                'color' => '#ef4444',
            ],
            [
                'bgColor' => '#ffedd5',
                'color' => '#f97316',
            ],
            [
                'bgColor' => '#fef3c7',
                'color' => '#f59e0b',
            ],
            [
                'bgColor' => '#fef9c3',
                'color' => '#eab308',
            ],
            [
                'bgColor' => '#ecfccb',
                'color' => '#84cc16',
            ],
            [
                'bgColor' => '#dcfce7',
                'color' => '#22c55e',
            ],
            [
                'bgColor' => '#d1fae5',
                'color' => '#10b981',
            ],
            [
                'bgColor' => '#ccfbf1',
                'color' => '#14b8a6',
            ],
            [
                'bgColor' => '#cffafe',
                'color' => '#06b6d4',
            ],
            [
                'bgColor' => '#e0f2fe',
                'color' => '#0ea5e9',
            ],
            [
                'bgColor' => '#dbeafe',
                'color' => '#3b82f6',
            ],
            [
                'bgColor' => '#e0e7ff',
                'color' => '#6366f1',
            ],
            [
                'bgColor' => '#ede9fe',
                'color' => '#8b5cf6',
            ],
            [
                'bgColor' => '#f3e8ff',
                'color' => '#a855f7',
            ],
            [
                'bgColor' => '#fae8ff',
                'color' => '#d946ef',
            ],
            [
                'bgColor' => '#fce7f3',
                'color' => '#ec4899',
            ],
            [
                'bgColor' => '#ffe4e6',
                'color' => '#f43f5e',
            ],
            [
                'bgColor' => '#fde68a',
                'color' => '#d97706',
            ],
            [
                'bgColor' => '#fbf9c3',
                'color' => '#b5cc41',
            ],
            [
                'bgColor' => '#fbf9c3',
                'color' => '#b5cc41',
            ],
            [
                'bgColor' => '#fbf9c3',
                'color' => '#b5cc41',
            ],
        ];
        // get numeric value of the name first letter

        $name = strtolower(substr($name, 0, 1));
        //$name = ord($name) - 97;

        return $colors[ord($name) - 97] ?? $colors[1];
    }
}
