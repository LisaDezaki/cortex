<script>
	import { getContext } from "svelte";

	import Input from '@/Components/UI/Input'
	import Error from '@/Components/UI/Error.svelte'
	import Label from '@/Components/UI/Label.svelte'
	import clsx  from 'clsx'
	
	const { form } = getContext("form");

	let {
		children,
		class: className,
		defaultValue,
		description = null,
		errors,
		inputClass,
		label,
		labelSrOnly = false,
		layout = 'stack',
		name,
		size = 'md',
		type,
        ...restProps
    } = $props()

	if (!name) { console.error(`The Field component requires a "name" field. You may have mistakenly used "id", which is set to ${restProps.id}`) }
	if (!$form[name]) { $form[name] = defaultValue || null }

	function findValue() {
		if (name.contains('.')) {
			parts = name.split('.')
			if (parts.length === 2) {
				return $form[parts[0]][parts[1]]
			}
			if (parts.length === 3) {
				return $form[parts[0]][parts[1]][parts[2]]
			}
			if (parts.length === 4) {
				return $form[parts[0]][parts[1]][parts[2]][parts[3]]
			}
		} else {
			return $form[name]
		}
	}

	let cx = {
		field:	clsx('field', {
			'w-full': !className || !className.includes('w-'),
			'relative grid grid-cols-2 gap-x-6 w-full': layout === 'block',
			'relative flex flex-col w-full': layout !== 'block',
		}, className),
		label:	clsx({ 'sr-only': labelSrOnly }),
		desc:	clsx(''),
		error:	clsx(''),
	}

</script>



<style lang="postcss">

	:global(.field-label) {
		@apply absolute top-0 left-0 leading-3 z-10;
		@apply mt-1 px-1.5;
		color: var(--text-neutral-softest);
	}

	.form-field.block {
		@apply relative grid grid-cols-2 gap-6 w-full;
	}

	.form-field:not(.block) {
		@apply relative flex flex-col;
	}

	/* .field-description {
		@apply mt-1 px-1.5 text-sm;
		color: var(--text-neutral-soft);
	} */

	.field-errors {
		@apply mt-1 px-1.5 text-sm;
		color: var(--text-neutral-soft);
	}

</style>



{#snippet labelBlock()}
	<Label
		for={name}
		text={label}
		class={cx.label}
	/>
{/snippet}

{#snippet descriptionBlock()}
	<div class={cx.desc}>{description}</div>
{/snippet}

{#snippet inputBlock()}
	{#if type}
		<Input {name} {type} {size}
			class="{inputClass} w-full"
			label={label}
			bind:checked={$form[name]}
			bind:value={$form[name]}
		{...restProps} />
	{:else if children}
		{@render children()}
	{/if}
{/snippet}

{#snippet errorBlock()}
	<Error class={cx.error} message={errors} />
{/snippet}


<div class={cx.field}>
	{#if layout == 'block'}
		<div class="col-span-2">
			{@render labelBlock()}
		</div>
		<div class="col-span-1">
			{@render descriptionBlock()}
		</div>
		<div class="col-span-1">
			{@render inputBlock()}
			{@render errorBlock()}
		</div>
	{:else}
		{@render labelBlock()}
		{@render descriptionBlock()}
		{@render inputBlock()}
		{@render errorBlock()}
	{/if}
</div>