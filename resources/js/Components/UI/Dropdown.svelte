<script>
	import { Link } from '@inertiajs/svelte'
	import { DropdownMenu } from "bits-ui";

	import Icon      from '@/Components/UI/Icon.svelte'
	import Thumbnail from '@/Components/UI/Thumbnail.svelte'

	let {
		children,
        class: className,
		contentClass,
		content,
		icon,
		label,
		isOpen = $bindable(),
		options,
		placeholder,
		trigger,
		value = $bindable(),
        ...restProps
    } = $props()

	function checkFocus(open) {
		isOpen = open
	}

	function updateValue(e) {
		e.preventDefault()
		console.log('updateValue', e)
	}

</script>





{#snippet item(itemProps, checked)}
	<button class="input-option w-full {itemProps.className}" class:active={checked} onclick={updateValue}>
		{#if itemProps.image}
			<Thumbnail class="rounded-full w-6" src={itemProps.image} />
		{/if}
		{#if itemProps.icon}
			<Icon name={itemProps.icon} size="md" />
		{/if}
		{#if itemProps.label}
			<span class="line-clamp-1">{itemProps.label}</span>
		{/if}
		{#if checked}
			<Icon class="ml-auto" name="Check" size="sm" />
		{/if}
	</button>
{/snippet}


<DropdownMenu.Root class="dropdown" onOpenChange={checkFocus} {...restProps}>

	<DropdownMenu.Trigger class="input input-dropdown-trigger {className}">
		{#if icon}
			<Icon class="input-icon" name={icon} size="md" />
		{/if}
		{#if !label && placeholder}
			<span class="font-style-placeholder input-value line-clamp-1 truncate {icon ? "pl-icon" : ""}">{placeholder}</span>
		{/if}
		{#if label}
			<span class="input-value line-clamp-1 truncate {icon ? "pl-icon" : ""}">{label}</span>
		{/if}
		{#if options}
			<Icon class="input-action ml-auto" name="CaretUpDown" size="sm" weight="light" />
		{/if}
	</DropdownMenu.Trigger>
 
	<DropdownMenu.Portal>
		<DropdownMenu.Content class="input-content {contentClass}" sideOffset={-1}>
			<DropdownMenu.RadioGroup bind:value>
				{#if options}
					{#each options as option}

						{#if option.separator}
							<DropdownMenu.Separator />
						{:else if option.children}
							<DropdownMenu.Sub>
								<DropdownMenu.SubTrigger>
									{@render item(option)}
								</DropdownMenu.SubTrigger>
								<DropdownMenu.Portal>
									<DropdownMenu.SubContent class="input-content w-52" align="start" alignOffset={-4} sideOffset={0}>
										{#each option.children as child}
											<DropdownMenu.Item>
												{@render item(child)}
											</DropdownMenu.Item>
										{/each}
									</DropdownMenu.SubContent>
								</DropdownMenu.Portal>
							</DropdownMenu.Sub>
						{:else}
							<DropdownMenu.Item>
								{@render item(option)}
							</DropdownMenu.Item>
						{/if}

					{/each}
				{/if}
			</DropdownMenu.RadioGroup>
		</DropdownMenu.Content>
	</DropdownMenu.Portal>
</DropdownMenu.Root>

<style lang="postcss">

	:global([data-dropdown-menu-separator]) {
		@apply border-t my-1;
		border-color: var(--border-neutral-softest);
	}

</style>