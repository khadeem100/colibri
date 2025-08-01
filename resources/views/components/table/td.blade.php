@props([
    'variant' => 'default',
    'variants' => [
        'strong' => 'text-lab-pr',
        'default' => 'text-lab-pr2',
        'weak' => 'text-lab-pr3',
        'muted' => 'text-lab-sc',
        'money' => 'text-mint',
    ],
    'weight' => 'normal',
    'weights' => [
        'normal' => 'font-normal',
        'medium' => 'font-medium',
        'bold' => 'font-bold',
    ],
    'numeric' => false,
])

<td class="h-12 align-middle leading-snug text-par-s max-w-32 border-b border-b-bord-pr px-2 first:pl-0 last:pr-0 {{ $variants[$variant] }} {{ $weights[$weight] }} {{ $numeric ? 'font-mono' : '' }}" {{ $attributes }}>
    {{ $slot }}
</td>