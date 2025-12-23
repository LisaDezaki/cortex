<script>
    import { useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import { Box, Flex, Grid, Inline, Stack, UploadContext } from '@/Components/Core'
	import Button	 from '@/Components/UI/Button.svelte'
	import Field	 from '@/Components/UI/Field.svelte'
	import Heading	 from '@/Components/UI/Heading.svelte'
	import Icon		 from '@/Components/UI/Icon.svelte'
	import Input	 from '@/Components/UI/Input'
	import ModalForm from '@/Components/UI/ModalForm.svelte'
	import Tag		 from '@/Components/UI/Tag.svelte'
	import Thumbnail from '@/Components/UI/Thumbnail.svelte'
    import clsx from 'clsx'

    let {
		endpoint,
		field,
		options = [],
		selected = $bindable([]),
		title = "Select Many"
	} = $props()

	const form = useForm({
		[field]: [...selected]
	})

	let layout = $state('grid') // 'grid' | 'list'
	function setLayout(type) {
		layout = type
	}

	function isActive(id) {
		return $form[field]?.includes(id)
	}

	function toggleSelection(id) {
		let isActive = $form[field]?.includes(id)
		$form[field] = isActive
			? [...$form[field].filter(f => f !== id) ]
			: [...$form[field], id ]
	}

	/**
	 * Classnames
	 * @type {Object}
	 */
	let cx = $derived({
	})

</script>



<ModalForm
	endpoint={endpoint}
	form={form}
	method="patch"
	size="xl"
	submitProps={{
		label: 'Save'
	}}
	title={title}
>
	<Flex class="px-4 pb-1.5">
		<Input.Text type="search" icon="MagnifyingGlass" />
		<Inline class="ml-auto -space-x-[1px]">
			<Button class="rounded-l" size="sm" style="hard" theme={layout === 'grid' ? "accent" : "neutral"} icon="GridFour"		onclick={() => setLayout('grid')} />
			<Button class="rounded-r" size="sm" style="hard" theme={layout === 'list' ? "accent" : "neutral"} icon="ListBullets"	onclick={() => setLayout('list')} />
		</Inline>
	</Flex>

	{#if layout === 'list'}
		<Stack class="max-h-[60vh] overflow-y-auto py-4">
			{#each options as option}
				<Flex gap={3} class="cursor-pointer px-6 py-1.5 {isActive(option.id) ? 'bg-accent-softest rounded text-accent' : ''}" onclick={() => toggleSelection(option.id)}>
					<Thumbnail class="bg-neutral-softest h-8 rounded w-8" src={option.image?.url} />
					<Stack class="-space-y-1 pt-0.5">
						<span class="text-sm">{option.name}</span>
						<span class="text-xs opacity-65">{option.alias}</span>
					</Stack>
					{#if $form[field]?.includes(option.id)}
						<Icon name="CheckCircle" size="sm" class="ml-auto text-accent" />
					{/if}
				</Flex>
			{/each}
		</Stack>
	{:else if layout === 'grid'}
		<Grid cols={4} gap={1} class="max-h-[60vh] overflow-y-auto p-4">
			{#each options as option}
				<Stack gap={1} class="col-span-1 cursor-pointer p-1 {isActive(option.id) ? 'bg-accent-softest rounded text-accent' : '' }" onclick={() => toggleSelection(option.id)}>
					<Thumbnail class="aspect-square bg-neutral-softest place-self-center rounded w-full" src={option.image?.url} />
					<Flex class="pl-1">
						<Stack class="-space-y-0.5">
							<span class="text-sm line-clamp-1 font-semibold">{option.name}</span>
							<span class="text-xs line-clamp-1 opacity-65">{option.alias}</span>
						</Stack>
						{#if isActive(option.id)}
							<Icon name="CheckCircle" size="md" class="ml-auto text-accent" />
						{/if}
					</Flex>
				</Stack>
			{/each}
		</Grid>
	{/if}
</ModalForm>