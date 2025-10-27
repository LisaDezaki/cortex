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
		faction,
		class: className
	} = $props()

</script>



<Stack gap={3} class="sticky top-0 h-screen pt-12 pb-6 {className}">
	{#if faction}


		<Media
			class="relative bg-neutral-softest h-48 place-self-center rounded shrink-0 text-neutral-softest w-48"
			icon="FlagBannerFold" iconWeight="fill"
			media={faction.getEmblem()}
			onclick={() => faction.addEmblem()}
		/>


		<Stack align="center" justify="center" gap={0} class="my-3">
			<Heading is="h3" as="h4">{faction.name}</Heading>
			<p class="text-sm">{faction.type}</p>
		</Stack>

		{#if faction.description}
			<Collapsible class="font-style-small mb-6" collapsed={true}>
				{faction.description}
			</Collapsible>
		{/if}


		<Separator class="mb-6" />


		<!-- Headquarters -->

		<Flex>
			<Inline class="font-medium h-7 min-w-24 mr-2 text-sm">Headquarters:</Inline>
			<Stack gap={1.5} class="w-full">
				<Input type="select" class="w-full" contentClass="w-44"
					placeholder="Unset"
					value={faction.headquarters?.slug}
					options={locations.items.map(l => ({
						image: l.image?.url,
						label: l.name,
						value: l.slug
					}))}
				/>
			</Stack>
		</Flex>


		<!-- Members -->

		<Flex>
			<Inline class="font-medium h-7 min-w-24 mr-2 text-sm">Members:</Inline>
			<Stack gap={1} class="w-full">
				{#each faction.members?.items as rel, i}
					<Input type="select" class="w-full" contentClass="w-44"
						placeholder="Unset"
						value={faction.members?.items[i].slug}
						options={characters.items?.map(c => ({
							id:    c.id,
							image: c.image?.url,
							label: c.name,
							value: c.slug
						}))}
						onUpdate={(opt) => faction.updateMember(opt, i)}
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
					onUpdate={(opt) => faction.addMember(opt)}
				/>
			</Stack>
		</Flex>


		<!-- Button -->

		<Button size="xl" style="hard" theme="accent" class="line-clamp-1 mt-auto rounded-full"
			icon="Eye" iconWeight="fill"
			label="View {faction.name}"
			href={faction.routes.show}
		/>

	{:else}
		<Thumbnail class="mb-1" />
		<Stack gap={2}>
			<Flex align="center" justify="between">
				<Skeleton class="h-6 w-1/3" />
				<Skeleton class="h-6 w-6" />
			</Flex>
			<Skeleton class="h-3 mb-2.5 w-1/2" />
		</Stack>
		<Stack gap={2} class="mb-2">
			<Skeleton class="h-3 mr-5" />
			<Skeleton class="h-3 mr-1" />
			<Skeleton class="h-3 mr-24" />
		</Stack>
		<Skeleton class="h-3 w-16" color="bg-accent-softest" />
		<Inline class="mt-16 w-full">
			<Skeleton class="h-3 w-16 mr-3" />
			<Skeleton class="h-6 rounded-full w-6" />
			<Skeleton class="h-3 w-24" />
		</Inline>
		<Inline class="mt-2">
			<Skeleton class="h-3 w-16 mr-3" />
			<Skeleton class="h-6 rounded-full w-6" />
			<Skeleton class="h-3 w-32" />
		</Inline>
		<Inline class="mt-2">
			<Skeleton class="h-3 w-24"  />
			<Skeleton class="h-6 rounded-full w-6" />
			<Skeleton class="h-6 rounded-full w-6" />
			<Skeleton class="h-6 rounded-full w-6" />
		</Inline>
		<Skeleton class="h-[50px] mt-auto rounded-lg" />
	{/if}

</Stack>