<script>
	import { Popover } from "bits-ui"
	import Flex      from '@/Components/Core/Flex.svelte'
	import Grid      from '@/Components/Core/Grid.svelte'
	import Stack     from '@/Components/Core/Stack.svelte'
	import Button    from '@/Components/UI/Button.svelte'
	import Input 	 from '@/Components/UI/Input'
	import Separator from '@/Components/UI/Separator.svelte'

	let {
        class: className,
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
		if (option.options) {
			suboptions = option.options
		} else {
			value = option.value
			selected = option
			isOpen = false
			onUpdate(option)
		}
	}

	function back() {
		suboptionQuery = ''
		suboptions = null
	}

	let selected = $state(options.find(o => o.value === value) || {})

</script>



<Popover.Root bind:open={isOpen}>

	<Popover.Trigger class="input p-{size} text-{size} {className}">
		<Input.Option {icon} {label} {placeholder} {text} {value} />
	</Popover.Trigger>

	<Popover.Portal>
		<Popover.Content
			class="input-content overflow-hidden"
			align="start" sideOffset={-1}
		>
			<Grid cols={2} gap={0} class="max-h-96 w-[200%] {suboptions ? 'translate-x-[-50%]' : ''} transition-transform">
				<Stack class="p-0.5">
					{#each options as option}
						{#if !option.hideIf}
							{#if option.separator}
								<Separator class="mx-2 my-0.5 w-auto" />
							{:else}
								<Flex align="center" value={option.value} onclick={() => selectItem(option)}>
									<Input.Option {...option} class="py-{size}" size={size} onclick={() => selectItem(option)} />
								</Flex>
							{/if}
						{/if}
					{/each}
				</Stack>
				<Stack class="relative max-h-full overflow-hidden">
					<Flex align="center" gap={0} class="bg-white p-0.5 w-full">
						<Button style="plain" theme="neutral" size="md" icon="CaretLeft" iconSize="sm" class="hover:bg-neutral-softest text-neutral-softest focus:outline-none border-none" onclick={back} />
						<input bind:value={suboptionQuery} class="border-none p-1 rounded text-neutral w-28" placeholder="Search" />
					</Flex>
					<Separator class="mx-2 w-auto" />
					<div class="overflow-y-auto p-0.5 max-h-80">
						{#each filteredSuboptions as suboption}
							 <Flex align="center" value={suboption.value} onclick={() => selectItem(suboption)}>
								<Input.Option {...suboption} class="py-{size}" size={size} onclick={() => selectItem(suboption)} />
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