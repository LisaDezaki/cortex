<script>
	import { Link, page } from '@inertiajs/svelte'


	//	Layout & Components

	import Flex					from '@/Components/Core/Flex.svelte'
	import Grid					from '@/Components/Core/Grid.svelte'
	import Inline				from '@/Components/Core/Inline.svelte'
	import Stack				from '@/Components/Core/Stack.svelte'
	import Button				from '@/Components/UI/Button.svelte'
	import Collapsible			from '@/Components/UI/Collapsible.svelte'
	import Heading				from '@/Components/UI/Heading.svelte'
	import Icon					from '@/Components/UI/Icon.svelte'
	import Input				from '@/Components/UI/Input.svelte'
	import Media				from '@/Components/UI/Media.svelte'
	import Separator			from '@/Components/UI/Separator.svelte'
	import Skeleton				from '@/Components/UI/Skeleton.svelte'
	import Tag					from '@/Components/UI/Tag.svelte'
	import Thumbnail			from '@/Components/UI/Thumbnail.svelte'


	//	Page & Component props

	import ProjectObject 	from '@/services/ProjectObject'
	const activeProject	  = $state(new ProjectObject($page.props.activeProject.data))
	const customFields	  = $state($page.props.customFields?.data)
	const characters      = $state(activeProject?.characters)
	const factions    	  = $state(activeProject?.factions)
	const locations    	  = $state(activeProject?.locations)

	let {
		character,
		class: className
	} = $props()

</script>



<Stack cols={2} gap={3} class="sticky top-0 h-screen pt-12 pb-6 {className}">
	{#if character}


		<Media
			class="bg-neutral-softest h-48 place-self-center rounded shrink-0 text-neutral-softest w-48"
			icon="UserCircle" iconWeight="fill"
			media={character.getPortrait()}
			onclick={() => character.addPortrait()}
		/>


		<Stack align="center" justify="center" gap={0} class="my-3 -space-y-0.5">
			<Heading is="h3" as="h4">{character.name}</Heading>
			<p class="text-neutral-soft text-sm">{character.alias}</p>
		</Stack>


		<Collapsible class="font-style-small" collapsed={true}>
			{character.description}
		</Collapsible>


		<Separator class="my-6" />

		

		<!-- Custom Fields -->

		{#each customFields as field}
		<Flex>
			<Inline class="font-medium h-7 min-w-24 mr-2 text-sm">{field?.label}:</Inline>
			<Stack class="w-full">
				{#if field?.options}
					<Input type="select" class="w-full" contentClass="w-44"
						placeholder="Unset"
						value={character.customFieldValues?.find(f => f.name === field.name)?.value}
						options={field.options?.map(o => ({
							label: o.label,
							value: o.value
						}))}
					/>
				{/if}
			</Stack>
		</Flex>
		{/each}



		<!-- Factions -->

		<Flex>
			<Inline class="font-medium h-7 min-w-24 mr-2 text-sm">Factions:</Inline>
			<Stack gap={1.5} class="w-full">
				{#each character.factions?.items as fac,i}
	
					<Input type="select" class="w-full" contentClass="w-44"
						placeholder="Unset"
						value={fac.slug}
						options={factions.items.map(f => ({
							image: f.image?.url,
							label: f.name,
							value: f.slug
						}))}
						onUpdate={(opt) => character.updateFaction(i,opt)}
					/>
	
				{/each}
				<Input type="select" class="w-full" contentClass="w-44"
					placeholder="Unset"
					value=""
					options={factions.items.map(f => ({
						image: f.image?.url,
						label: f.name,
						value: f.slug
					}))}
				/>
			</Stack>
		</Flex>



		<!-- Location -->

		<Flex>
			<Inline class="font-medium h-7 min-w-24 mr-2 text-sm">Location:</Inline>
			<Stack gap={1.5} class="w-full">
				<Input type="select" class="w-full" contentClass="w-44"
					placeholder="Unset"
					value={character.location?.slug}
					options={locations.items.map(l => ({
						image: l.image?.url,
						label: l.name,
						value: l.slug
					}))}
				/>
			</Stack>
		</Flex>


		<!-- Relationships -->

		<Flex>
			<Inline class="font-medium h-7 min-w-24 mr-2 text-sm">Relationships:</Inline>
			{#if character.relationships?.items.length > 0}
				<Stack gap={1} class="w-full">
					{#each character.relationships?.items as rel, i}
						<Input type="select" class="w-full" contentClass="w-44"
							placeholder="Unset"
							value={character.relationships?.items[i].slug}
							options={characters.items?.map(c => ({
								image: c.image?.url,
								label: c.name,
								value: c.slug
							}))}
						/>
					{/each}
				</Stack>
			{:else if character.relationships?.items.length === 0}
				<Input type="select" class="w-full" contentClass="w-44"
					placeholder="Unset"
					value=""
					options={characters.items?.map(c => ({
						image: c.image?.url,
						label: c.name,
						value: c.slug
					}))}
				/>
			{/if}
		</Flex>



		<!-- Appearance -->

		<Flex>
			<Inline class="font-medium h-7 min-w-24 mr-2 text-sm">Appearance:</Inline>
			<Flex wrap gap={0.5} class="py-1">
				{#if character.appearance}
					{#each character.appearance.split(',') as trait}
						<Tag plain class="bg-neutral-softest font-style-small h-6 py-0.5">{trait}</Tag>
					{/each}
				{/if}
				<Button style="plain" theme="accent" size="sm" class="bg-accent-softest h-6 w-6"
					onclick={() => character.setAppearance()}
					icon="Plus" iconSize="xs"
				/>
			</Flex>
		</Flex>



		<!-- Personality -->

		<Flex>
			<Inline class="font-medium min-w-24 mr-2 text-sm">Personality:</Inline>
			<Flex wrap gap={0.5} class="py-1">
				{#if character.personality}
					{#each character.personality.split(',') as trait}
						<Tag plain class="bg-neutral-softest font-style-small h-6 py-0.5">{trait}</Tag>
					{/each}
				{/if}
				<Button style="plain" theme="accent" size="sm" class="bg-accent-softest h-6 w-6"
					onclick={() => character.setAppearance()}
					icon="Plus" iconSize="xs"
				/>
			</Flex>
		</Flex>



		<!-- Button -->

		<Button size="xl" style="hard" theme="accent" class="line-clamp-1 mt-auto rounded-full"
			icon="Eye" iconWeight="fill"
			label="View {character.name}"
			href={character.routes.show}
		/>

	{:else}
		<Thumbnail class="h-48 place-self-center rounded shrink-0 w-48" />
		<Stack gap={1.5} class="my-4 w-full" align="center">
			<Skeleton class="h-6 w-1/2" />
			<Skeleton class="h-3 w-1/3" />
		</Stack>
		<Stack gap={1.5} class="my-2">
			<Skeleton class="h-3 mr-5" />
			<Skeleton class="h-3 mr-1" />
			<Skeleton class="h-3 mr-24" />
			<Skeleton class="h-3 mt-4 w-16" color="bg-accent-softest" />
		</Stack>
		<Separator class="mt-6 mb-6" />
		<Flex align="center" class="w-full">
			<Skeleton class="h-3 w-16" />
			<Skeleton class="h-7 ml-auto w-44" />
		</Flex>
		<Flex align="center" class="w-full">
			<Skeleton class="h-3 w-16" />
			<Skeleton class="h-7 ml-auto w-44" />
		</Flex>
		<Flex align="center" class="w-full">
			<Skeleton class="h-3 w-16" />
			<Skeleton class="h-7 ml-auto w-44" />
		</Flex>
		<Flex align="center" class="w-full">
			<Skeleton class="h-3 w-24" />
			<Skeleton class="h-7 ml-auto w-44" />
		</Flex>
		<Flex align="center" class="w-full">
			<Skeleton class="h-3 w-20" />
			<Skeleton class="h-7 ml-6 w-7" color="bg-accent-softest" />
		</Flex>
		<Flex align="center" class="w-full">
			<Skeleton class="h-3 w-16" />
			<Skeleton class="h-7 ml-10 w-7" color="bg-accent-softest" />
		</Flex>
		<Skeleton class="h-[50px] mt-auto" color="bg-accent-softest" border="rounded-full" />
	{/if}
</Stack>