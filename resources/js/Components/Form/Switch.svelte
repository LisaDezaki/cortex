<script>

	import { Switch } from "bits-ui";
	import Form from '@/Components/Form'

    let {
		checked = $bindable(false),
        class: className,
		id,
		label,
		name,
        ...attrs
    } = $props()

</script>

{#if label}
	<Form.Label class="form-switch {attrs.disabled ? 'disabled' : ''}">
		<span class="switch-label">{label}</span>
		<Switch.Root class="switch {className}" id={id} name={name} bind:checked {...attrs}>
			<Switch.Thumb class="switch-thumb"></Switch.Thumb>
		</Switch.Root>
	</Form.Label>
{:else}
	<Switch.Root class="switch {className}" id={id} name={name} bind:checked {...attrs}>
		<Switch.Thumb class="switch-thumb"></Switch.Thumb>
	</Switch.Root>
{/if}

<style lang="postcss">

	:global(.form-switch) {
		@apply flex items-center gap-2 min-h-11 px-3 py-2 w-full;
		@apply border rounded-lg;
		background-color: transparent;
		border-color: var(--border-soft);
		color: var(--text-input);
		&:hover {
			border-color: var(--border-input);
		}
	}

	:global(.switch) {
		@apply inline-flex rounded-full h-6 w-10 p-0.5 border flex-shrink-0;
		background-color: var(--bg-input);
		border-color: var(--border-input);
		@apply focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2;
		&[data-state="checked"] {
			background: var(--gradient-primary);
		}
	}

	:global(.switch-thumb) {
		@apply rounded-full h-full aspect-square border transition;
		background-color: var(--text-label);
		border-color: var(--border-disabled);
		&[data-state="checked"] {
			background-color: var(--bg-white);
		}
	}

	:global(.switch-thumb[data-state="checked"]) {
		@apply translate-x-4;
	}

	:global(.form-switch.disabled .inline-label),
	:global(.form-switch.disabled .switch) {
		@apply cursor-not-allowed;
	}

	:global(.form-switch.disabled .switch) {
		background-color: var(--bg-disabled);
		border-color: var(--border-disabled);
		color: var(--text-disabled);
	}

	:global(.form-switch.disabled .switch-thumb) {
		background-color: var(--bg-disabled);
		border-color: transparent;
		color: var(--text-disabled);
	}

	.switch-label {
		@apply text-base w-full;
	}

</style>