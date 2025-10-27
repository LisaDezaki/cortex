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

</script>



<Stack gap={0} class="bg-slate-50 sticky top-0 h-screen overflow-hidden shadow-xl z-10 {className}">
	<Stack class="grow overflow-y-auto">
		{#if location}


			<!-- <Media
				class="aspect-square bg-neutral-softest mb-1.5 min-h-40 place-self-center relative shrink-0 text-neutral-softest w-full"
				icon="MapPin" iconWeight="fill"
				media={location.getMap()}
				onclick={() => location.addMap()}
			/> -->

			<Map
				pannable={false} zoomable={false}
				class="aspect-square rounded-none"
				location={location}
				bind:activeChild={hoveredLocation}
			/>


			<Stack align="center" justify="center" gap={0} class="my-3 px-6">
				<Heading is="h3" as="h4" class="text-center">{location.name}</Heading>
				<p class="text-neutral-soft text-sm">{location.type}</p>
			</Stack>


			<!-- <Collapsible class="font-style-small px-6" collapsed={true}>
				{location.description}
			</Collapsible> -->


			<!-- <Separator class="mb-6" /> -->


			<!-- Children -->

			{#if location.children.length > 0}
				<Stack align="start" gap={3} class="px-6 py-3">
					<Inline class="font-style-button text-neutral-softest text-sm">Points of Interest</Inline>
					<Grid cols={2} gap={0} class="w-full">
						{#each location.children as loc,i}
							<Inline
								gap={1.5}
								class="border cursor-pointer {hoveredLocation?.slug === loc.slug ? "border-accent" : "border-transparent"}"
								onmouseover={() => hoverLocation(loc)}
								onmouseout={() => hoverLocation()}
							>
								<Flex align="center" justify="center" class="p-1 {hoveredLocation?.slug === loc.slug ? "bg-accent text-white" : "bg-neutral-softest text-neutral"}">
									<Icon name={loc.icon || 'MapPinSimple'} size="sm" weight={hoveredLocation?.slug === loc.slug ? 'fill' : 'light'} />
								</Flex>
								<span class="font-light text-sm line-clamp-1">{loc.name}</span>
								{#if hoveredLocation?.slug === loc.slug}
									<Button style="plain" theme="accent" class="ml-auto" size="sm" icon="GpsFix" iconSize="xs" />
								{/if}
								<!-- <Inline class="font-light text-xs line-clamp-1 bg-neutral-softest h-5 px-0.5 text-neutral-softest ml-auto">
									<span class="line-clamp-1">{loc.coordinates.x}, {loc.coordinates.y}</span>
								</Inline> -->
							</Inline>
						{/each}
					</Grid>
					<!-- <Button style="plain" theme="neutral" size="sm"
						class="place-self-center"
						label="Show more"
					/> -->
				</Stack>
			{/if}
			


			<!-- Custom Fields -->

			<!-- {#each customFields as field}
			<Flex>
				<Inline class="font-medium h-7 min-w-24 mr-2 text-sm">{field?.label}:</Inline>
				<Stack class="w-full">
					{#if field?.options}
						<Input type="select" class="w-full" contentClass="w-44"
							placeholder="Unset"
							value={location.customFieldValues?.find(f => f.name === field.name)?.value}
							options={field.options?.map(o => ({
								label: o.label,
								value: o.value
							}))}
						/>
					{/if}
				</Stack>
			</Flex>
			{/each} -->



			



			<!-- Location -->

			<!-- <Flex>
				<Inline class="font-medium h-7 min-w-24 mr-2 text-sm">Location:</Inline>
				<Stack gap={1.5} class="w-full">
					<Input type="select" class="w-full" contentClass="w-44"
						placeholder="Unset"
						value={location.location?.slug}
						options={locations.items.map(l => ({
							image: l.image?.url,
							label: l.name,
							value: l.slug
						}))}
					/>
				</Stack>
			</Flex> -->

			<!-- Characters -->

			{#if location.characters.length > 0}
				<Stack align="start" gap={3} class="px-6 py-3">
					<Inline class="font-style-button text-neutral-softest text-sm">Characters</Inline>
					<Grid cols={3} gap={1.5} class="w-full">
						{#each location.characters as char,i}
							<Inline>
								<Thumbnail src={char.image?.url} class="h-6 w-6" />
								<span class="text-sm">{char.name}</span>
							</Inline>
						{/each}
					</Grid>
					<!-- <Button style="plain" theme="neutral" size="sm"
						class="place-self-center"
						label="Show more"
					/> -->
				</Stack>
			{/if}
			

			<!-- Characters -->

			<!-- <pre>{JSON.stringify(location.characters,null,3)}</pre> -->

			<!-- <Flex>
				<Inline class="font-medium h-7 min-w-24 mr-2 text-sm">Characters:</Inline>
				{#if location.characters?.length > 0}
					<Stack gap={1} class="w-full">
						{#each location.characters as rel, i}
							<Input type="select" class="w-full" contentClass="w-44"
								placeholder="Unset"
								value={location.characters[i].slug}
								options={characters.items?.map(c => ({
									image: c.image?.url,
									label: c.name,
									value: c.slug
								}))}
							/>
						{/each}
					</Stack>
				{:else if location.characters?.length === 0}
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
			</Flex> -->



			<!-- Appearance -->

			<!-- <Flex>
				<Inline class="font-medium h-7 min-w-24 mr-2 text-sm">Appearance:</Inline>
				<Flex wrap gap={0.5} class="py-1">
					{#if location.appearance}
						{#each location.appearance.split(',') as trait}
							<Tag plain class="bg-neutral-softest font-style-small h-6 py-0.5">{trait}</Tag>
						{/each}
					{/if}
					<Button style="plain" theme="accent" size="sm" class="bg-accent-softest h-6 w-6"
						onclick={() => location.setAppearance()}
						icon="Plus" iconSize="xs"
					/>
				</Flex>
			</Flex> -->



			<!-- Personality -->

			<!-- <Flex>
				<Inline class="font-medium min-w-24 mr-2 text-sm">Personality:</Inline>
				<Flex wrap gap={0.5} class="py-1">
					{#if location.personality}
						{#each location.personality.split(',') as trait}
							<Tag plain class="bg-neutral-softest font-style-small h-6 py-0.5">{trait}</Tag>
						{/each}
					{/if}
					<Button style="plain" theme="accent" size="sm" class="bg-accent-softest h-6 w-6"
						onclick={() => location.setAppearance()}
						icon="Plus" iconSize="xs"
					/>
				</Flex>
			</Flex> -->



			<!-- Button -->

			

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
		{/if}
	</Stack>
	<Stack class="shrink-0 px-6 py-3">
		<Button
			size="xl" style="hard" theme="accent"
			class="line-clamp-1 mt-auto rounded-full"
			icon="Eye" iconWeight="fill"
			label="View {location?.name}"
			href={location?.routes.show}
		/>
	</Stack>
</Stack>



<!-- <Stack class="col-span-1">
	<Stack class="sticky top-0 h-screen pt-16 pb-6">

		{#if selected}
			<Thumbnail aspect="aspect-video" src={selected.image?.url} class="mb-3 shadow-md" />

			<Stack gap={0}>
				<Flex align="start" justify="between">
					<Heading is="h3" as="h5">{selected.name}</Heading>
					<Button style="plain" theme="neutral" icon="DotsThreeOutlineVertical" iconSize="md" iconWeight="fill" class="rounded-full hover:bg-neutral-softest" />
				</Flex>
				<p class="-mt-1 mb-3 text-sm">{selected.type}</p>
			</Stack>

			<Collapsible class="font-style-small mb-6" collapsed={true}>
				{selected.description}
			</Collapsible>

			{#if selected.getMap()}
				<Thumbnail src={selected.getMap()?.url} class="mb-3" />
				<Flex wrap gap={0.5} class="mb-3">
					{#each selected.children as loc}
						<Tag plain class="bg-neutral-softest font-style-tiny py-0.5">{loc.name}</Tag>
					{/each}
				</Flex>
			{/if}

			<Button size="xl" style="hard" theme="accent" class="line-clamp-1 mt-auto"
				icon="Eye" iconWeight="fill"
				label="View {selected.name}"
				href={selected.routes.show}
			/>
		{/if}

	</Stack>
</Stack> -->