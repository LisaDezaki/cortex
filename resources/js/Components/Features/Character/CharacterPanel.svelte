<script>
	import { Link, page, router } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'


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
		
		<Stack gap={0} class="px-6 pt-3 pb-6">


			<!-- Heading -->

			<Stack gap={0.5} class="mb-3 px-6 -space-y-1">
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
				<Collapsible class="font-style-small mb-6 min-h-16" collapsed={true}>
					{character.description}
				</Collapsible>
			{/if}
			<Separator />



			<!-- Custom Fields -->
	
			{#each customFields as field}
				<Flex align="start" class="font-light py-1.5">
					<p class="min-h-5 text-xs text-neutral-soft min-w-20 pt-0.5">{field?.label}</p>
					<p class="min-h-5 text-sm text-neutral">{character.customFieldValues?.find(f => f.name === field.name)?.displayValue}</p>
					<Button style="plain" theme="accent" size="sm" class="h-5 w-5 ml-auto rounded-full"
						onclick={() => character.setCustomField()}
						icon="PencilSimple" iconSize="xs"
					/>
				</Flex>
				<Separator />
			{/each}



			<!-- Factions -->
	
			<Flex align="start" class="font-light py-1.5">
				<p class="min-h-5 text-xs text-neutral-soft min-w-20 pt-0.5">Factions</p>
				<p class="min-h-5 text-sm text-neutral">
					{#if character.factions?.items.length > 0}
						{#each character.factions?.items as fac,i}
							<Link href={route('factions.show', { faction: fac.slug })}>
								{fac.name}
							</Link>{character.factions?.items.length-1 !== i ? ', ' : ''}
						{/each}
					{:else}
						<span class="font-style-placeholder text-sm text-neutral-softest">None</span>
					{/if}
				</p>
				<Button style="plain" theme="accent" size="md" class="h-5 w-5 ml-auto rounded-full"
					onclick={() => character.setFactions()}
					icon="PencilSimple" iconSize="xs"
				/>
			</Flex>
			<Separator />



			<!-- Location -->
	
			<Flex align="start" class="font-light py-1.5">
				<p class="min-h-5 text-xs text-neutral-soft min-w-20 pt-0.5">Location</p>
				<p class="min-h-5 text-sm text-neutral">
					{#if character.location}
						<Link href={route('locations.show', { location: character.location?.slug })}>{character.location?.name}</Link>
					{:else}
						<span class="font-style-placeholder text-sm text-neutral-softest">None</span>
					{/if}
				</p>
				<Button style="plain" theme="accent" size="sm" class="h-5 w-5 ml-auto rounded-full"
					onclick={() => character.setLocation()}
					icon="PencilSimple" iconSize="xs"
				/>
			</Flex>
			<Separator />



			<!-- Relationships -->
	
			<Flex align="start" class="font-light py-1.5">
				<p class="min-h-5 text-xs text-neutral-soft min-w-20 pt-0.5">Relationships</p>
				<p class="min-h-5 text-sm text-neutral">
					{#if character.relationships?.items.length > 0}
						{#each character.relationships?.items as rel,i}
							<Link href={route('characters.show', { character: rel.slug })}>
								{rel.name}
							</Link>{character.relationships?.items.length-1 !== i ? ', ' : ''}
						{/each}
					{:else}
						<span class="font-style-placeholder text-sm text-neutral-softest">None</span>
					{/if}
				</p>
				<Button style="plain" theme="accent" size="sm" class="h-5 w-5 ml-auto rounded-full"
					onclick={() => character.setRelationships()}
					icon="PencilSimple" iconSize="xs"
				/>
			</Flex>
			<Separator />



			<!-- Appearance -->
	
			<Flex align="start" class="font-light py-1.5">
				<p class="min-h-5 text-xs text-neutral-soft min-w-20 pt-0.5">Appearance</p>
				<p class="min-h-5 text-sm text-neutral line-clamp-2">
					{#if character.appearance}
						{#each character.appearance.split(',') as trait,i}
							{trait}{character.appearance.split(',').length-1 !== i ? ', ' : ''}
						{/each}
					{:else}
						<span class="font-style-placeholder text-sm text-neutral-softest">None</span>
					{/if}
				</p>
				<Button style="plain" theme="accent" size="sm" class="h-5 w-5 ml-auto rounded-full"
					onclick={() => character.updateAppearance()}
					icon="PencilSimple" iconSize="xs"
				/>
			</Flex>
			<Separator />



			<!-- Personality -->
	
			<Flex align="start" class="font-light py-1.5">
				<p class="min-h-5 text-xs text-neutral-soft min-w-20 pt-0.5">Personality</p>
				<p class="min-h-5 text-sm text-neutral line-clamp-2">
					{#if character.personality}
						{#each character.personality.split(',') as trait,i}
							{trait}{character.personality.split(',').length-1 !== i ? ', ' : ''}
						{/each}
					{:else}
						<span class="font-style-placeholder text-sm text-neutral-softest">None</span>
					{/if}
				</p>
				<Button style="plain" theme="accent" size="sm" class="h-5 w-5 ml-auto rounded-full"
					onclick={() => character.updatePersonality()}
					icon="PencilSimple" iconSize="xs"
				/>
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