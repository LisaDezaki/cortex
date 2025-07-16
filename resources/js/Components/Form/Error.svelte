<script>
    let {
        message,
        ...attrs
    } = $props()
</script>

{#if message}
    <div class="mt-1" {...attrs}>
        <p class="font-light tracking-wide text-sm text-red-600 dark:text-red-400">
            {message}
        </p>
    </div>
{/if}