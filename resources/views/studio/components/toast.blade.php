{{-- resources/views/studio/components/toast.blade.php --}}
<div
    x-data="{ visible: false, message: '' }"
    x-on:studio-toast.window="
        message = $event.detail.message;
        visible = true;
        window.setTimeout(() => visible = false, 2500)
    "
    x-show="visible"
    x-transition
    x-cloak
    aria-live="polite"
    class="fixed bottom-20 left-1/2 z-30 -translate-x-1/2 rounded-lg bg-zinc-900 px-4 py-3 text-sm font-medium text-white shadow-lg md:bottom-6"
>
    <span x-text="message"></span>
</div>
