@props([
    'title',
    'description',
])

<div class="flex w-full flex-col text-center">
    <heading size="xl">{{ $title }}</heading>
    <subheading>{{ $description }}</subheading>
</div>
