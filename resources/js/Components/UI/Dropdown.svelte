<script>
	import { Link } from '@inertiajs/svelte'
	import { Menubar } from "bits-ui";

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
	}

	function selectItem(value) {
		// console.log('Dropdown.selectValue()', value)
	}

</script>





{#snippet item(itemProps, checked)}
	<button class="input-option w-full {itemProps.className}" class:active={checked} onclick={updateValue}>
		{#if itemProps.image !== undefined}
			<Thumbnail class="border-[0.5px] rounded-full w-6" iconSize={16} src={itemProps.image} />
		{/if}
		{#if itemProps.icon !== undefined}
			<Icon name={itemProps.icon} size="md" />
		{/if}
		{#if itemProps.label}
			<span class="line-clamp-1 text-left w-full">{itemProps.label}</span>
		{/if}
		{#if checked}
			<Icon class="ml-auto" name="Check" size="sm" />
		{/if}
	</button>
{/snippet}


<Menubar.Root class="dropdown" onOpenChange={checkFocus} {...restProps}>
	<Menubar.Menu>

	<Menubar.Trigger class="input input-dropdown-trigger {className}">
		{#if icon}
			<Icon class="input-icon" name={icon} size="md" />
		{/if}
		<!-- {#if !label && placeholder}
			<span class="font-style-placeholder input-value line-clamp-1 truncate {icon ? "pl-icon" : ""}">{placeholder}</span>
		{/if} -->
		{#if value}
			<span class="input-value line-clamp-1 truncate {icon ? "pl-icon" : ""}">{value}</span>
		{/if}
		{#if options}
			<Icon class="input-action ml-auto" name="CaretUpDown" size="sm" weight="light" />
		{/if}
	</Menubar.Trigger>
 
	<Menubar.Portal>
		<Menubar.Content class="input-content {contentClass}" sideOffset={-1}>
			<Menubar.RadioGroup bind:value>
				{#if options}
					{#each options as option}

						{#if option.separator}
							<Menubar.Separator />
						{:else if option.children}
							<Menubar.Sub>
								<Menubar.SubTrigger>
									{@render item(option)}
								</Menubar.SubTrigger>
								<Menubar.Portal>
									<Menubar.SubContent class="input-content w-52" align="start" alignOffset={-4} sideOffset={0}>
										{#each option.children as child}
											<Menubar.Item onSelect={selectItem}>
												<!-- <button class="w-full" onclick={selectItem}> -->
													{@render item(child)}
												<!-- </button> -->
											</Menubar.Item>
										{/each}
									</Menubar.SubContent>
								</Menubar.Portal>
							</Menubar.Sub>
						{:else}
							<Menubar.Item onSelect={selectItem}>
								{@render item(option)}
							</Menubar.Item>
						{/if}

					{/each}
				{/if}
			</Menubar.RadioGroup>
		</Menubar.Content>
	</Menubar.Portal>
	</Menubar.Menu>
</Menubar.Root>

<style lang="postcss">

	:global([data-dropdown-menu-separator]) {
		@apply border-t my-1;
		border-color: var(--border-neutral-softest);
	}

</style>