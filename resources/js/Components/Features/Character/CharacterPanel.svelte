<script>
	import { page } from '@inertiajs/svelte'


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
	import Sidebar				from '@/Components/UI/Sidebar.svelte'
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



<Sidebar gap={0} class="bg-slate-50 sticky top-0 h-screen overflow-y-auto shadow-xl z-10 {className}">
	{#if character}


		<!-- Head -->

		<Media
			class="relative bg-slate-200 hover:inner-shadow-lg h-48 place-self-center shrink-0 text-neutral-softest w-full transition-all"
			media={character.getBanner()}
			onclick={() => character.openModal('setBanner')}
		/>
		<Media
			class="relative bg-slate-200 hover:inner-shadow-lg border border-slate-50 h-32 -mt-16 place-self-center rounded shrink-0 text-neutral-softest w-32 transition-all"
			icon="UserCircle" iconWeight="fill"
			media={character.getPortrait()}
			onclick={() => character.openModal('setPortrait')}
		/>
			
		
		<!-- Body -->
		
		<Stack gap={3} class="px-6 pt-3 pb-6">


			<!-- Heading -->

			<Stack gap={0} class="-space-y-1 px-6">
				<Inline align="center" gap={0} class="place-self-center">
					<Heading is="h3" as="h4" heading={character.name} />
					<div class="relative place-self-start w-0">
						<Button size="sm" theme="accent" icon="PencilSimple" iconSize="xs" class="absolute ml-1 rounded-full" onclick={() => character.openModal('rename')} />
					</div>
				</Inline>
				<Inline align="center" gap={0} class="place-self-center">
					<p class="text-neutral-soft text-sm">{character.alias}</p>
					<div class="relative w-0">
						<Button size="sm" theme="accent" icon="PencilSimple" iconSize="xs" class="ml-1 rounded-full" onclick={() => character.setAlias()} />
					</div>
				</Inline>
			</Stack>


			<!-- Description -->
			
			{#if character.description}
				<Collapsible class="font-style-small" collapsed={true}>
					{character.description}
				</Collapsible>
			{/if}
	
			<Separator class="my-3" />


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
								onUpdate={(opt) => character.updateCustomField(field.id, opt.value)}
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
								id:    f.id,
								image: f.image?.url,
								label: f.name,
								value: f.slug
							}))}
							onUpdate={(opt) => character.syncFactions(opt,i)}
						/>
		
					{/each}
					<Input type="select" class="w-full" contentClass="w-44"
						placeholder="Unset"
						value=""
						options={factions.items.map(f => ({
							id:    f.id,
							image: f.image?.url,
							label: f.name,
							value: f.slug
						}))}
						onUpdate={(opt) => character.addFaction(opt)}
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
							id:    l.id,
							image: l.image?.url,
							label: l.name,
							value: l.slug
						}))}
						onUpdate={(opt) => character.setLocation(opt.id)}
					/>
				</Stack>
			</Flex>



			<!-- Relationships -->
	
			<Flex>
				<Inline class="font-medium h-7 min-w-24 mr-2 text-sm">Relationships:</Inline>
				<Stack gap={1} class="w-full">
					{#each character.relationships?.items as rel, i}
						<Input type="select" class="w-full" contentClass="w-44"
							placeholder="Unset"
							value={character.relationships?.items[i].slug}
							options={characters.items?.map(c => ({
								id:    c.id,
								image: c.image?.url,
								label: c.name,
								value: c.slug
							}))}
						/>
					{/each}
					<Input type="select" class="w-full" contentClass="w-44"
						placeholder="Unset"
						value=""
						options={characters.items?.map(c => ({
							id:    c.id,
							image: c.image?.url,
							label: c.name,
							value: c.slug
						}))}
						onUpdate={(opt) => character.openModal('relationship', { related: characters.find(opt.id) })}
					/>
				</Stack>
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
						onclick={() => character.updateAppearance()}
						icon="Plus" iconSize="xs"
					/>
				</Flex>
			</Flex>


			
			<!-- Personality -->
	
			<Flex>
				<Inline class="font-medium h-7 min-w-24 mr-2 text-sm">Personality:</Inline>
				<Flex wrap gap={0.5} class="py-1">
					{#if character.personality}
						{#each character.personality.split(',') as trait}
							<Tag plain class="bg-neutral-softest font-style-small h-6 py-0.5">{trait}</Tag>
						{/each}
					{/if}
					<Button style="plain" theme="accent" size="sm" class="bg-accent-softest h-6 w-6"
						onclick={() => character.updatePersonality()}
						icon="Plus" iconSize="xs"
					/>
				</Flex>
			</Flex>
		</Stack>


	{:else}
		<Thumbnail class="aspect-[7/3] max-h-48 rounded-none w-full" />
		<Thumbnail class="border border-slate-50 h-32 -mt-16 place-self-center rounded shrink-0 w-32" />
		<Stack gap={1.5} class="my-4 w-full" align="center">
			<Skeleton class="h-6 w-1/4" />
			<Skeleton class="h-3 w-1/3" />
		</Stack>
		<Stack gap={2} class="my-2 px-6">
			<Skeleton class="h-3 mr-5" />
			<Skeleton class="h-3 mr-1" />
			<Skeleton class="h-3 mr-24" />
			<Skeleton class="h-5 mx-auto my-1 rounded-full w-20" color="bg-accent-softest" />
			<Separator class="my-3" />
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
			</Flex>
			<Flex align="center" class="w-full">
				<Skeleton class="h-3 w-16" />
			</Flex>
		</Stack>


	{/if}
	<Button
		size="xl" style="hard" theme="accent"
		class="sticky bottom-3 line-clamp-1 mx-6 mt-auto rounded-full"
		icon="Eye" iconWeight="fill"
		label="View {character?.name}"
		href={character?.routes.show}
	/>
</Sidebar>