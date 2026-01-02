<script>
    import { useForm } from '@inertiajs/svelte'
    import { route } from 'momentum-trail'

	import { Box, Flex, Grid, Inline, Stack, UploadContext } from '@/Components/Core'
	import Button	 from '@/Components/UI/Button.svelte'
	import Entity	 from '@/Components/UI/Entity.svelte'
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
		title = "Select Many",
		...restProps
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
	submitProps={{ label: 'Save' }}
	title={title}
{...restProps}>
	<Flex class="px-3 pb-1.5">
		<Input.Text type="search" size="sm" icon="MagnifyingGlass" />
		<Inline class="ml-auto -space-x-[1px]">
			<Button class="rounded-l" size="sm" style="hard" theme={layout === 'grid' ? "accent" : "neutral"} icon="GridFour"		onclick={() => setLayout('grid')} />
			<Button class="rounded-r" size="sm" style="hard" theme={layout === 'list' ? "accent" : "neutral"} icon="ListBullets"	onclick={() => setLayout('list')} />
		</Inline>
	</Flex>

	{#if layout === 'list'}
		<Stack class="max-h-[60vh] overflow-y-auto px-3 py-1.5" gap={1.5}>
			{#each options as option}
				<Entity
					entity={option}
					active={$form[field]?.includes(option.id)}
					onclick={() => toggleSelection(option.id)}
					layout="inline"
					size="sm"
				/>
			{/each}
		</Stack>
	{:else if layout === 'grid'}
		<Grid cols={4} gap={1.5} class="max-h-[60vh] overflow-y-auto px-3 py-1.5">
			{#each options as option}
				<Entity
					entity={option}
					active={$form[field]?.includes(option.id)}
					onclick={() => toggleSelection(option.id)}
				/>
			{/each}
		</Grid>
	{/if}
</ModalForm>