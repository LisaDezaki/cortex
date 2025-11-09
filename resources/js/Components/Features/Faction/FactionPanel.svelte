<script>
	import { Link, page } from '@inertiajs/svelte'
	import { route } from 'momentum-trail'


	//	Layout & Components

	import Flex			from '@/Components/Core/Flex.svelte'
	import Inline		from '@/Components/Core/Inline.svelte'
	import Stack		from '@/Components/Core/Stack.svelte'
	import Button		from '@/Components/UI/Button.svelte'
	import Collapsible	from '@/Components/UI/Collapsible.svelte'
	import Heading		from '@/Components/UI/Heading.svelte'
	import Media		from '@/Components/UI/Media.svelte'
	import Separator	from '@/Components/UI/Separator.svelte'
	import Sidebar		from '@/Components/UI/Sidebar.svelte'
	import Skeleton		from '@/Components/UI/Skeleton.svelte'
	import Thumbnail	from '@/Components/UI/Thumbnail.svelte'


	//	Page & Component props

	const customFields = $state($page.props.customFields?.data)

	let {
		faction,
		class: className
	} = $props()


	//	Tailwind class management

	const cx = {
		sidebar:  "bg-slate-50 sticky top-0 h-screen overflow-y-auto shadow-xl z-10 " + className,
		banner:   "relative bg-slate-200 hover:inner-shadow-lg h-40 place-self-center shrink-0 text-neutral-softest w-full transition-all",
		emblem:   "relative bg-slate-200 hover:inner-shadow-lg border border-slate-50 h-32 -mt-16 place-self-center rounded shrink-0 text-neutral-softest w-32 transition-all",
		info:     "font-light px-1 py-1.5",
		label:    "min-h-5 text-xs text-neutral-soft min-w-20 pt-0.5",
		value:    "min-h-5 text-sm text-neutral",
		empty:    "min-h-5 text-sm text-neutral-softest italic",
		button: {
			edit: "h-5 w-5 ml-auto rounded-full",
			view: "sticky bottom-3 line-clamp-1 mx-6 mt-auto rounded-full"
		}
	}

</script>



<Sidebar class={cx.sidebar} gap={0}>
	{#if faction}


		<!-- Head -->

		<Media
			class={cx.banner}
			media={faction.getMedia('banner')}
			onclick={() => faction.openModal('setBanner')}
		/>
		<Media
			class={cx.emblem}
			media={faction.getMedia('emblem')}
			onclick={() => faction.openModal('setEmblem')}
			icon="FlagBannerFold" iconWeight="fill"
		/>


		<!-- Body -->

		<Stack gap={0} class="px-4 pt-3 pb-6">


			<!-- Heading -->

			<Stack gap={0.5} class="mb-3 px-6 -space-y-1">
				<Heading is="h3" as="h4" class="place-self-center text-center">{faction.name}</Heading>
				<p class="place-self-center text-neutral-soft text-sm">{faction.type}</p>
			</Stack>


			<!-- Description -->

			{#if faction.description}
				<Collapsible class="font-style-small mb-3 min-h-16 px-3" collapsed={true}>
					{faction.description}
				</Collapsible>
			{/if}
			<Separator />



			<!-- Custom Fields -->
	
			{#each customFields as field}
				<Flex align="start" class={cx.info}>
					<p class={cx.label}>{field?.label}</p>
					<p class={cx.value}>{faction.customFieldValues?.find(f => f.name === field.name)?.displayValue}</p>
					<Button class={cx.button.edit}
						style="plain" theme="accent" size="sm"
						icon="PencilSimple" iconSize="xs"
						onclick={() => faction.setCustomField()}
					/>
				</Flex>
				<Separator />
			{/each}



			<!-- Headquarters -->
	
			<Flex align="start" class={cx.info}>
				<p class={cx.label}>Headquarters</p>
				<p class={cx.value}>
					{#if faction.headquarters}
						<Link href={faction.headquarters.routes.show}>
							{faction.headquarters?.name}
						</Link>
					{:else}
						<span class={cx.empty}>None</span>
					{/if}
				</p>
				<Button class={cx.button.edit}
					style="plain" theme="accent" size="sm"
					icon="PencilSimple" iconSize="xs"
					onclick={() => faction.setHeadquarters()}
				/>
			</Flex>
			<Separator />


	
			<!-- Members -->
	
			<Flex align="start" class={cx.info}>
				<p class={cx.label}>Members</p>
				<p class={cx.value}>
					{#if faction.members?.items.length > 0}
						{#each faction.members?.items as member,i}
							<Link href={member.routes.show}>
								{member.name}
							</Link>{faction.members?.items.length-1 !== i ? ', ' : ''}
						{/each}
					{:else}
						<span class={cx.empty}>None</span>
					{/if}
				</p>
				<Button class={cx.button.edit}
					style="plain" theme="accent" size="sm"
					icon="PencilSimple" iconSize="xs"
					onclick={() => character.setRelationships()}
				/>
			</Flex>
			<Separator />
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
</Sidebar>