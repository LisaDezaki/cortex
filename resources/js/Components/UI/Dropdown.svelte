<script>
	import { Popover } from "bits-ui"
	import Flex      from '@/Components/Core/Flex.svelte'
	import Grid      from '@/Components/Core/Grid.svelte'
	import Stack     from '@/Components/Core/Stack.svelte'
	import Button    from '@/Components/UI/Button.svelte'
	import Input 	 from '@/Components/UI/Input'
	import Separator from '@/Components/UI/Separator.svelte'

	let {
		children,
        class: className,
		contentProps = {},
		icon,
		label,
		isOpen = $bindable(false),
		options,
		placeholder,
		size = "md",
		text,
		onUpdate = () => {},
		value = $bindable()
    } = $props()

	let suboptionQuery 		= $state('')
	let suboptions	   		= $state(null)
	let filteredSuboptions 	= $derived(suboptions?.filter(s => `${s.value} ${s.label}`.toLowerCase().includes(suboptionQuery.toLowerCase()) ))

	function selectItem(option) {
		if (option.onclick) {
			option.onclick()
		} else if (option.options) {
			suboptions = option.options
		} else {
			value = option.value
			selected = option
			// isOpen = false
			onUpdate(option)
		}
		isOpen = false
	}

	function back() {
		suboptionQuery = ''
		suboptions = null
	}

	let selected = $state(options.find(o => o.value === value) || {})

</script>



<Popover.Root bind:open={isOpen}>

	{#if children}
		<Popover.Trigger class={className}>
			{@render children()}
		</Popover.Trigger>
	{:else}
		<Popover.Trigger class="input p-{size} text-{size} {className}">
			<Input.Option item={selected} {placeholder} hideCount />
		</Popover.Trigger>
	{/if}

	<Popover.Portal>
		<Popover.Content
			class="input-content overflow-hidden"
			align="start" sideOffset={-1} {...contentProps}
		>
			<Grid cols={2} gap={0} class="h-full w-[200%] {suboptions ? 'translate-x-[-50%]' : ''} transition-transform">
				<Stack class="p-0.5">
					{#each options as option}
						{#if !option.hideIf}
							{#if option.separator}
								<Separator class="mx-2 my-0.5 w-auto" />
							{:else}
								<Flex align="center" value={option.value} onclick={() => selectItem(option)}>
									<Input.Option {...option} class="p-{size}" size={size} onclick={() => selectItem(option)} />
								</Flex>
							{/if}
						{/if}
					{/each}
				</Stack>
				<Stack class="relative max-h-full overflow-hidden">
					<Flex align="center" gap={0} class="bg-white p-0.5 w-full">
						<Button style="plain" theme="neutral" size={size} icon="CaretLeft" iconSize="sm" class="hover:bg-neutral-softest text-neutral-softest focus:outline-none border-none" onclick={back} />
						<input bind:value={suboptionQuery} class="border-none p-1 rounded text-neutral text-{size} w-28" placeholder="Search" />
					</Flex>
					<Separator class="mx-2 w-auto" />
					<div class="overflow-y-auto p-0.5 max-h-80">
						{#each filteredSuboptions as suboption}
							 <Flex align="center" value={suboption.value} onclick={() => selectItem(suboption)}>
								<Input.Option {...suboption} class="p-{size}" size={size} onclick={() => selectItem(suboption)} />
							</Flex>
						{:else}
							<p class="font-style-placeholder text-center">0 results.</p>
						{/each}
					</div>
				</Stack>
			</Grid>
		</Popover.Content>
	</Popover.Portal>
</Popover.Root>