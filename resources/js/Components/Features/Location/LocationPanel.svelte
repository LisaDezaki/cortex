<script>
	import { Link, page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'


	//	Layout & Components

	import Flex				from '@/Components/Core/Flex.svelte'
	import Grid				from '@/Components/Core/Grid.svelte'
	import Inline			from '@/Components/Core/Inline.svelte'
	import Map				from '@/Components/Core/Map'
	import Stack			from '@/Components/Core/Stack.svelte'
	import Button			from '@/Components/UI/Button.svelte'
	import Collapsible		from '@/Components/UI/Collapsible.svelte'
	import Heading			from '@/Components/UI/Heading.svelte'
	import Separator		from '@/Components/UI/Separator.svelte'
	import Sidebar			from '@/Components/UI/Sidebar.svelte'
	import SidebarListItem 	from '@/Components/UI/SidebarListItem.svelte'
	import Skeleton			from '@/Components/UI/Skeleton.svelte'
	import Thumbnail		from '@/Components/UI/Thumbnail.svelte'


	//	Page & Component props

	const customFields = $state($page.props.customFields?.data)
	const climate   = $state($page.props.options.locationTags)

	let {
		location,
		class: className
	} = $props()


	//	Tailwind class management

	const cx = {
		sidebar:  "bg-slate-50 sticky top-0 h-screen overflow-y-auto shadow-xl z-10 " + className,
		banner:   "relative bg-slate-200 hover:inner-shadow-lg h-40 place-self-center shrink-0 text-neutral-softest w-full transition-all",
		emblem:   "relative bg-slate-200 hover:inner-shadow-lg border border-slate-50 h-32 -mt-16 place-self-center rounded shrink-0 text-neutral-softest w-32 transition-all",
		info:     "font-light group px-1 py-2",
		label:    "text-xs text-neutral-soft min-w-20 pt-0.5",
		value:    "text-sm text-neutral",
		empty:    "text-sm text-neutral-softest italic",
		button: {
			edit: "h-5 w-5 ml-auto rounded-full",
			view: "sticky bottom-3 line-clamp-1 mx-6 mt-auto rounded-full"
		}
	}

</script>



<Sidebar class={cx.sidebar} gap={0}>
	{#if location}


		<!-- Head -->

		<Map.Context
			class="flex-col w-full"
			location={location}
			map={location.getMedia('map')}
			mapItems={location.mapItems.all}
			onUpload={() => location.openModal('setMedia', {type:'map'})}
		>

			<!-- Head -->

			<Map.Preview
				class="aspect-square w-full"
			/>


			<!-- Body -->

			<Stack gap={3} class="relative px-4 py-3">
	
	
				<!-- Heading -->
	
				<Stack align="center" justify="center" gap={0.5} class="px-6">
					<Heading is="h3" as="h4" class="text-center">{location.name}</Heading>
					<p class="text-neutral-soft text-sm">{location.type}
						{#if location.mapData?.location}
							in <Link href={route('locations.show', { location: location.mapData.location.slug})}>{location.mapData.location.name}</Link>
						{/if}
					</p>
				</Stack>


				<!-- Panel Actions -->

				<Inline align="center" gap={0} class="border border-neutral-softest place-self-center p-0.5 rounded-full">
					<Button
						icon="Star" iconSize="sm" iconWeight={location.starred ? 'fill' : 'regular'}
						class="cursor-pointer p-0.5 rounded-full text-amber-400 hover:bg-amber-50"
						onclick={() => location.star()}
					/>
					<Button
						icon="PencilSimple" iconSize="sm" iconWeight="regular"
						class="cursor-pointer p-0.5 rounded-full text-accent hover:bg-accent-softest"
						onclick={() => location.star()}
					/>
					<Button
						icon="Trash" iconSize="sm" iconWeight="regular"
						class="cursor-pointer p-0.5 rounded-full text-danger hover:bg-danger-softest"
						onclick={() => location.openModal('delete')}
					/>
				</Inline>


				<!-- Description -->
	
				{#if location.description}
					<Collapsible class="font-style-small min-h-16 px-1.5" collapsed={true}>
						{location.description}
					</Collapsible>
				{/if}
				<Separator />

		</Stack>
		<Stack gap={0} class="relative px-4">
	
				<!-- MapItems -->
				<Map.Legend class="grid grid-cols-2 mb-6" />

				<!-- Climate -->
				<SidebarListItem
					label="Climate"
					onclick={() => location.openModal('climate', { options: climate })}
					value={location.climate?.split(',').join(', ') || undefined}
				/>

				<!-- Custom Fields -->
				{#each customFields as field}
					<SidebarListItem
						label={field.label}
						onclick={() => location.setCustomField()}
						value={location.customFieldValues?.find(f => f.name === field.name)?.displayValue}
					/>
				{/each}

			</Stack>	
		</Map.Context>

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
	<Button class={cx.button.view}
		size="xl" style="hard" theme="accent"
		icon="Eye" iconWeight="fill"
		label="View {location?.name}"
		href={location?.routes.show}
	/>
</Sidebar>