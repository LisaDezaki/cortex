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



<Stack gap={0} class="bg-slate-50 sticky top-0 h-screen overflow-y-auto shadow-xl z-10 {className}">
	{#if faction}


		<!-- Head -->

		<Media
			class="relative bg-slate-200 h-48 place-self-center shrink-0 text-neutral-softest w-full"
			media={faction.getBanner()}
			onclick={() => faction.openModal('setBanner')}
		/>
		<Media
			class="relative bg-slate-200 border border-slate-50 h-32 -mt-16 place-self-center rounded shrink-0 text-neutral-softest w-32"
			icon="FlagBannerFold" iconWeight="fill"
			media={faction.getEmblem()}
			onclick={() => faction.openModal('setEmblem')}
		/>


		<!-- Body -->

		<Stack gap={3} class="px-6 pt-3 pb-6">


			<!-- Heading -->

			<Stack align="center" justify="center" gap={0} class="my-3 px-6">
				<Heading is="h3" as="h4" class="text-center">{faction.name}</Heading>
				<p class="text-neutral-soft text-sm">{faction.type}</p>
			</Stack>


			<!-- Description -->

			{#if faction.description}
				<Collapsible class="font-style-small" collapsed={true}>
					{faction.description}
				</Collapsible>
			{/if}
	
			<Separator class="my-3" />
	
	
			<!-- Headquarters -->
	
			<Flex>
				<Inline class="font-medium h-7 min-w-24 mr-2 text-sm">Headquarters:</Inline>
				<Stack gap={1.5} class="w-full">
					<Input type="select" class="w-full" contentClass="w-44"
						placeholder="Unset"
						value={faction.headquarters?.slug}
						options={locations.items.map(l => ({
							id:    l.id,
							image: l.image?.url,
							label: l.name,
							value: l.slug
						}))}
					/>
				</Stack>
			</Flex>


			<!-- Ranks -->

			<!-- <Flex>
				<Inline class="font-medium h-7 min-w-24 mr-2 text-sm">Ranks:</Inline>
				<Stack gap={1} class="w-full">
					{#each faction.ranks as rank}
						<Input type="select" class="w-full" contentClass="w-44"
							placeholder="Unset"
							value={rank.name.toLowerCase()}
							options={faction.ranks?.map(r => ({
								id:    r.id,
								label: r.name,
								value: r.name.toLowerCase()
							}))}
						/>
					{/each}
				</Stack>
			</Flex> -->


			<!-- Leader -->
	
			<!-- <Flex>
				<Inline class="font-medium h-7 min-w-24 mr-2 text-sm">Leader:</Inline>
				<Stack gap={1.5} class="w-full">
					<Input type="select" class="w-full" contentClass="w-44"
						placeholder="Unset"
						options={faction.members?.items?.map(c => ({
							id:    c.id,
							image: c.image?.url,
							label: c.name,
							value: c.slug
						}))}
					/>
				</Stack>
			</Flex> -->
	
	
			<!-- Members -->
	
			<Stack gap={1} class="w-full">
				<Inline class="font-medium h-7 min-w-24 mr-2 text-sm">Members:</Inline>
				{#each faction.members?.items as member, i}
					<Flex>
						<Input type="select" rootClass="w-full" contentClass="w-44"
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
						{#if faction.ranks?.length > 1}
							<Input type="select" containerClass="w-24" contentClass="w-24"
								placeholder="Unset"
								value={member.rank?.name.toLowerCase()}
								options={faction.ranks?.map(r => ({
									id:    r.id,
									label: r.name,
									value: r.name.toLowerCase()
								}))}
							/>
						{/if}
					</Flex>
				{/each}
				<Flex>
					<Input type="select" rootClass="w-full" contentClass="w-44"
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
					{#if faction.ranks?.length > 1}
						<Input type="select" class="w-24" contentClass="w-24"
							placeholder="Unset"
							value=""
							options={faction.ranks?.map(r => ({
								id:    r.id,
								label: r.name,
								value: r.name.toLowerCase()
							}))}
						/>
					{/if}
				</Flex>
			</Stack>
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
		label="View {faction?.name}"
		href={faction?.routes.show}
	/>
</Stack>