<script>
	import clsx from 'clsx'
	import { getContext } from "svelte"
	import Inline from '@/Components/Core/Inline.svelte'
	import Stack  from '@/Components/Core/Stack.svelte'
	import Button from '@/Components/UI/Button.svelte'
	import Icon   from '@/Components/UI/Icon.svelte'

	const {
		getActive,
		getHovered,
		getItems,
		getMap,
		handleConfirmCoordinates,
		handleItemHover,
		setActiveItem,
		legendClass,
	} = getContext("map-context");

	let {
		class: className,
		pannable,
		zoomable
	} = $props()

	/**
	 * Classnames
	 * @type {Object}
	 */
	let cx = $derived({
		legend:     clsx('pb-3', legendClass),
		title: 		clsx('font-light min-h-6 min-w-20 pt-0.5 px-0.5 text-xs text-neutral-soft'),
		list: 		clsx('grid grid-cols-2 gap-[1px] min-w-48 shrink-0 w-full'),
		item: 		clsx('cursor-pointer text-sm text-neutral'),
		itemHover: 	clsx('bg-accent-softest text-accent'),
		icon: 		clsx('bg-neutral-softest p-1 text-neutral'),
		iconHover: 	clsx('bg-accent p-1 text-white'),
		cursor: 	getActive() ? "cursor-crosshair" : (pannable ? "cursor-grab" : "cursor-pointer"),
		action:     clsx('ml-auto rounded-none'),
		check:      clsx('bg-accent text-white'),
		gps:	    clsx('text-neutral-softer hover:bg-accent-softest hover:text-accent')
	})

	function isHovered(item) {
		return getHovered()?.mappable?.id === item.mappable?.id
	}

</script>



{#each [
	{ title: 'Locations',  defaultIcon: 'MapPinSimple', list: getItems().locations },
	{ title: 'Characters', defaultIcon: 'User',			list: getItems().characters }
] as mapItems}
	{#if mapItems.list?.length > 0}
		<Stack class={cx.legend}>
			<span class={cx.title}>{mapItems.title}</span>
			<ul class={cx.list}>
				{#each mapItems.list as item}
					<li class="col-span-1">
						<Inline gap={1.5}
							class="{cx.item} {isHovered(item) ? cx.itemHover : ''}"
							onmouseover={() => handleItemHover(item)}
							onmouseout={ () => handleItemHover()}
						>
							<Icon
								name={item.mappable.icon || mapItems.defaultIcon}
								size="sm"
								weight={isHovered(item) ? 'fill' : 'regular'}
								class={isHovered(item) ? cx.iconHover : cx.icon}
							/>
							<span class="line-clamp-1">{item.mappable.name}</span>
							{#if getMap() && getActive()?.mappable.id === item.mappable?.id}
								<Button
									class="{cx.action} {cx.check}"
									icon={item.x && item.y ? "Check" : "Check"}
									iconSize="xs"
									iconWeight="bold"
									onclick={handleConfirmCoordinates}
								/>
							{:else if getMap() && !getActive()}
								<Button
									class="{cx.action} {cx.gps}"
									theme={item.x && item.y ? "accent" : ""}
									icon={item.x && item.y ? "GpsFix" : "Gps"}
									iconSize="xs"
									iconWeight={item.x && item.y ? 'fill' : 'regular'}
									onclick={() => setActiveItem(item)}
								/>
							{/if}
						</Inline>
					</li>
				{/each}
			</ul>
		</Stack>
	{/if}
{/each}