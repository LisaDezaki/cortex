<script>
	import { page, useForm } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'

	import { Flex, Grid, Stack } from '@/Components/Core'

	import Button    from '@/Components/UI/Button.svelte'
	import Entity    from '@/Components/UI/Entity.svelte'
	import Icon		 from '@/Components/UI/Icon.svelte'
	import Input     from '@/Components/UI/Input'
	import ModalForm from '@/Components/UI/ModalForm.svelte'
	import Thumbnail from '@/Components/UI/Thumbnail.svelte'

	import ProjectObject from '@/services/ProjectObject'

	let {
		entity,
		entityList,
		field,
		selected = null,
		...restProps
	} = $props()

	let active = new ProjectObject($page.props.activeProject?.data)
	let options = $derived(active[entityList])
	let selectedOption = $derived(options.find(selected) || null)

	const form = useForm({
		[field]: [{
			id: selected,
			label: ''
		}],
	})

	let query  = $state('')
	let layout = $state('grid')

	let filteredOptions = $derived(active[entityList]?.items?.filter(opt => opt.name.toLowerCase().includes(query.toLowerCase())))

	function selectOption(option) {
		$form[field][0].id = option && selected !== option.id ? option.id : null
		selected = option && selected !== option.id ? option.id : null
	}

</script>



<ModalForm title="Link entity: {entity.name}" size="xl"
	form={form}
	method="patch"
	reloadPageProps={['characters']}
{...restProps}>


	{#if selected == null}

		<Stack class="max-h-[75vh] overflow-hidden">
			<Flex gap={3} class="flex-none px-4 pb-1.5">
				<Input.Text 	bind:value={query}  class="w-32" icon="MagnifyingGlass" placeholder="Search..."	size="sm" />
				<Input.Select 	bind:value={layout} class="w-32" icon="Shapes" 			placeholder="Layout..." size="sm" options={[
					{ label: 'Grid', value: 'grid' },
					{ label: 'List', value: 'list' },
				]} />
			</Flex>

			{#if layout === 'grid'}
				<Grid cols={5} gap={3} class="flex-1 overflow-y-auto px-4 pt-1.5 pb-4">
					{#each active[entityList]?.items?.filter(opt => opt.id !== entity.id && opt.name.toLowerCase().includes(query.toLowerCase())) as option}
						<Entity
							entity={option}
							onclick={() => selectOption(option)}
						/>
					{/each}
				</Grid>
			{:else}
				<Stack gap={1.5} class="flex-1 overflow-y-auto px-4 pt-1.5 pb-4">
					{#each active[entityList]?.items?.filter(opt => opt.id !== entity.id && opt.name.toLowerCase().includes(query.toLowerCase())) as option}
						<Entity
							entity={option}
							layout="inline"
							size="sm"
							onclick={() => selectOption(option)}
						/>
					{/each}
				</Stack>
			{/if}
		</Stack>

	{:else}

		<Button icon="ArrowLeft" style="plain" theme="neutral" class="absolute top-0 left-3 rounded-full" onclick={() => selectOption()} />

		<Flex justify="center" class="p-3 pt-6 -space-x-6 w-full">
			<Stack gap={1.5}>
				<Thumbnail class="bg-neutral-softest rounded-full h-40 w-40" src={entity?.image?.url} />
			</Stack>
			
			<Stack gap={1.5}>
				<Thumbnail class="bg-neutral-softest rounded-full h-40 w-40" src={selectedOption?.image?.url} />
			</Stack>
		</Flex>

		<Flex align="center" justify="center">
			<p class="font-style-large line-clamp-1 text-right w-full">{entity?.name}</p>
			<Icon class="mx-3 text-neutral-softer w-8" name="Link" weight="light" />
			<p class="font-style-large line-clamp-1 text-left w-full">{selectedOption?.name}</p>
		</Flex>

		<Flex justify="center" class="p-6 pt-3 w-full">
			<Input.Text bind:value={$form[field][0].label} placeholder="Context label"
				class="w-48"
			/>
		</Flex>

	{/if}
</ModalForm>