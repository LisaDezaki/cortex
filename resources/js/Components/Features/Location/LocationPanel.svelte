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

	import Map					from '@/Components/Features/Location/Map.svelte'


	//	Page & Component props

	import ProjectObject 	from '@/services/ProjectObject'
	const activeProject	  = $state(new ProjectObject($page.props.activeProject.data))
	const customFields	  = $state($page.props.customFields?.data)
	const characters      = $state(activeProject?.characters)
	const factions    	  = $state(activeProject?.factions)
	const locations    	  = $state(activeProject?.locations)

	let {
		location,
		class: className
	} = $props()

	let hoveredLocation = $state()

	function hoverLocation(loc) {
		hoveredLocation = loc
		// console.log(hoveredLocation)
	}

	function setCoordinates(item) {
		console.log('set coordinates', item)
	}

</script>



<Sidebar class={className}>
	{#if location}


		<!-- Head -->

		<Map
			pannable={false} zoomable={false}
			class="aspect-square rounded-none shrink-0"
			location={location}
			bind:activeChild={hoveredLocation}
		/>


		<!-- Body -->

		<Stack gap={3} class="px-6 pt-5 pb-6 w-full">


			<!-- Heading -->

			<Stack align="center" justify="center" gap={0} class="mb-1.5 px-6">
				<Heading is="h3" as="h4" class="text-center">{location.name}</Heading>
				<p class="text-neutral-soft text-sm">{location.type}
					{#if location.mapData?.location}
						in <Link href={route('locations.show', { location: location.mapData.location.slug})}>{location.mapData.location.name}</Link>
					{/if}
				</p>
			</Stack>


			<!-- Description -->

			{#if location.description}
				<Collapsible class="font-style-small" collapsed={true} collapsedClass = "line-clamp-2 overflow-hidden">
					{location.description}
				</Collapsible>
			{/if}

			<Separator class="w-full" />


			<!-- MapItems -->

			{#each [
				{ type: 'character', title: 'Characters', icon: 'User', buttonLabel: 'Add character' },
				{ type: 'faction',   title: 'Factions',   icon: 'FlagBannerFold', buttonLabel: 'Add headquarters' },
				{ type: 'location',  title: 'Locations',  icon: 'MapPinSimple', buttonLabel: 'Add point of interest' }
			] as group}
				{#if location.mapItems?.[group.type+'s']?.length > 0}
					<Stack align="start" gap={3} class="py-3">
						<Inline class="font-style-button text-neutral-softest text-sm">{group.title}</Inline>
						<Grid cols={2} gap={0} class="w-full">
							{#each location.mapItems[group.type+'s'] as item,i}
								<Inline
									gap={0}
									class="border cursor-pointer {hoveredLocation?.slug === item.mappable?.slug ? "border-accent" : "border-transparent"}"
									onmouseover={() => hoverLocation(item.mappable)}
									onmouseout={() => hoverLocation()}
								>
									<Flex align="center" justify="center" class="p-1 {hoveredLocation?.slug === item.mappable?.slug ? "bg-accent text-white" : "bg-neutral-softest text-neutral"}">
										<Icon name={item.mappable?.icon || group.icon} size="sm" weight={hoveredLocation?.slug === item.mappable?.slug ? 'fill' : 'light'} />
									</Flex>
									<span class="font-light line-clamp-1 ml-1.5 text-sm truncate">{item.mappable?.name}</span>
									{#if hoveredLocation?.slug === item.mappable?.slug}
										<Button size="sm"
											class="h-full ml-auto rounded-none {item.x && item.y ? 'bg-accent-softest text-accent' : 'bg-neutral-softest text-neutral-softer'}"
											icon={item.x && item.y ? "GpsFix" : "Gps"} iconSize={14}
											onclick={() => setCoordinates(item.mappable)}
										/>
										<!-- <Icon
											class="ml-auto mr-1 {item.x && item.y ? 'text-accent' : 'text-neutral-softer'}"
											name={item.x && item.y ? "GpsFix" : "Gps"}
											size={14}
										/> -->
									{/if}
								</Inline>
							{/each}
						</Grid>
					</Stack>
				{/if}
			{/each}

			<!-- <Button theme="accent" class="place-self-center rounded-full"
				label="New point of interest"
			/> -->

		</Stack>	
	{:else}


		<Thumbnail class="aspect-square place-self-center rounded-none shrink-0 w-full" />
		<Stack gap={1.5} class="my-4 w-full" align="center">
			<Skeleton class="h-6 w-1/2" />
			<Skeleton class="h-3 w-1/5" />
		</Stack>
		<Stack gap={1.5} class="my-4 px-6">
			<Skeleton class="h-3 w-24" />
			<Grid cols={2} gap={0} class="py-2">
				{#each Array(6) as poi}
					<Inline class="border border-transparent mr-4">
						<Skeleton class="h-6 rounded-none shrink-0 w-6" />
						<Skeleton class="h-3 max-w-full w-{Math.floor(Math.random() * 10) * 4 + 12}" />
					</Inline>
				{/each}
			</Grid>
		</Stack>
		<Stack gap={1.5} class="my-4 px-6">
			<Skeleton class="h-3 w-24" />
			<Grid cols={2} gap={0} class="py-2">
				{#each Array(6) as poi}
					<Inline class="border border-transparent mr-4">
						<Skeleton class="h-6 rounded-none shrink-0 w-6" />
						<Skeleton class="h-3 max-w-full w-{Math.floor(Math.random() * 10) * 4 + 12}" />
					</Inline>
				{/each}
			</Grid>
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


	{/if}
	<Button
		size="xl" style="hard" theme="accent"
		class="sticky bottom-3 line-clamp-1 mx-6 mt-auto rounded-full"
		icon="Eye" iconWeight="fill"
		label="View {location?.name}"
		href={location?.routes.show}
	/>
</Sidebar>