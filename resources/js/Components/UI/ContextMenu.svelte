<script>
	import { Link } from '@inertiajs/svelte'
	import { ContextMenu } from "bits-ui";

	import { Flex, Grid, Inline, Stack } from '@/Components/Core';
	import Button 	 from '@/Components/UI/Button.svelte';
	import Icon 	 from '@/Components/UI/Icon.svelte';
	import Separator from '@/Components/UI/Separator.svelte';
	import Thumbnail from '@/Components/UI/Thumbnail.svelte'
    import clsx from 'clsx'

	let {
		children,
		class: className,
		icon,
		iconSize = 16,
		iconWeight = 'regular',
		iconOptions,
		label,
		options,
		...restProps
	} = $props()

	/**
	 * Classnames
	 * @type {Object}
	 */
	let cx = $derived({
		item: clsx({
			'context-menu relative cursor-pointer h-8 px-1.5 py-1 rounded w-full': true,
			'bg-accent-softest': item.active,
			'text-neutral-softest': item.disabled,
			'text-accent': item.theme === 'accent',
			'text-danger': item.theme === 'danger',
			'text-neutral-strong active:text-accent': item.theme === undefined
		}),
		img: clsx({
			'border p-[1px] rounded-full w-6' : true,
			'border-accent': item.active,
			'border-neutral-softest': !item.active,
		})
		
	})

	let contextSearch   = $state('')

	function queried(opts) {
		return opts.filter(o => {
			return contextSearch === '' ? true : o.label?.toLowerCase().includes(contextSearch?.toLowerCase())
		})
	}
  
</script>



{#snippet item(item)}
	<Flex class={cx.item} align="center" justify="center" gap={2}>

		{#if item.image !== undefined}
			<Thumbnail class={cx.img}
				iconSize={16} src={item.image?.url}
				imageClass="rounded-full"
			/>
		{:else if item.icon}
			<Icon name={item.icon} class={item.active ? "text-accent": ""}
				size={item.iconSize || iconSize} weight={item.iconWeight || iconWeight}
			/>
		{/if}

		{#if item.label}
			<span class="font-style-small line-clamp-1 py-0.5 truncate grow" class:text-accent={item.active}>{item.label}</span>
		{/if}

		{#if item.options}
			<Icon name="CaretRight" size="sm" class="ml-auto text-neutral-softer" />
		{/if}

		{#if item.active}
			<Icon name="Check" size="sm" class="ml-auto text-accent" />
		{/if}

		{#if item.disabled}
			<Icon name="X" size="sm" class="ml-auto text-danger" />
		{/if}

		{#if item.onclick}
			<button class="absolute inset-0 text-transparent" onclick={(e) => item.onclick(e, item)}>{item.label}</button>
		{:else if item.href}
			<Link class="absolute inset-0 text-transparent" href={item.href}>{item.label}</Link>
		{/if}

	</Flex>
{/snippet}

<ContextMenu.Root {...restProps}>
	<ContextMenu.Trigger class="{className} select-none">
		{#if icon}
			<Icon name={icon} size={iconSize} weight={iconWeight} />
		{/if}
		{#if label}
			<span>{label}</span>
		{/if}
		{@render children?.()}
	</ContextMenu.Trigger>
	<ContextMenu.Portal>
		<ContextMenu.Content class="bg-white border border-neutral-softer max-h-96 outline-none overflow-y-auto p-0.5 rounded-lg shadow-xl w-48 focus-visible:outline-none">

			{#if iconOptions}
				<Inline gap={0} class="w-full">
					{#each iconOptions.map(opt => ({...opt, iconSize: "sm", iconWeight: opt.iconWeight || 'regular' })) as iconOption}
						<ContextMenu.Item class="grow rounded hover:bg-{iconOption.theme || 'neutral'}-softest">
							{@render item(iconOption)}
						</ContextMenu.Item>
					{/each}
				</Inline>
				<ContextMenu.Separator class="border-t border-neutral-softest mx-2 my-0.5 w-auto" />
			{/if}

			{#each options as option}

				{#if option.hasOwnProperty('hideIf') && option.hideIf === true}
					<!-- Skip rendering this option -->
				{:else if option.separator}
					<ContextMenu.Separator class="border-t border-neutral-softest mx-2 my-0.5 w-auto" />
				{:else if option.options}
					<ContextMenu.Sub>
						<ContextMenu.SubTrigger class="data-[state=open]:bg-neutral-softest rounded">
							{@render item(option)}
						</ContextMenu.SubTrigger>
						<ContextMenu.SubContent
							class="bg-white border border-neutral-softer outline-none rounded-lg shadow-xl w-48 z-100 ring-0! ring-transparent!"
							sideOffset={4}
						>
							<Flex align="center" class="border-b border-neutral-softest p-0.5 text-neutral-soft w-full z-10">
								<!-- <span class="line-clamp-1 px-3 text-sm truncate">{option.label}</span> -->
								<input bind:value={contextSearch} class="border-none pl-2 px-1 py-1 rounded font-style-input text-neutral w-28" placeholder="Search" />
								<!-- <Button style="soft" theme="accent" class="h-8 w-8 ml-auto"
									icon="Plus" size="sm"
									onclick={option.create}
								/> -->

								<!-- <ContextMenu.Item class="h-8 w-8 ml-auto"> -->
									<!-- <Flex align="center" gap={0} class="bg-white p-0.5 w-full">
										<Button size="md" icon="CaretLeft" iconSize="sm" class="text-neutral-softest focus:outline-none border-none" onclick={back} />
										<input bind:value={suboptionQuery} class="border-none px-1 py-1 rounded text-sm w-28" placeholder="Search" />
										<Button size="sm" icon="Plus" theme="accent" class="ml-auto" />
									</Flex> -->
									<Button style="plain" theme="accent" size="xs" class="h-7 w-7 ml-auto"
										icon="Plus" iconSize="sm"
										onclick={option.create}
									/>
									<!-- <Button style="plain" theme="accent" size="md" class="ml-auto"
										 icon="Plus" iconSize="sm"
									/> -->
								<!-- </ContextMenu.Item> -->
							</Flex>
							{#if option.options.length > 0}
								<Stack class="max-h-96 overflow-y-auto p-0.5" gap={0}>
									<!-- <pre>{JSON.stringify(contextSearch,null,3)}</pre> -->
									{#each queried(option.options) as opt}
										<ContextMenu.Item class="hover:bg-{opt.theme || 'neutral'}-softest rounded">
											{@render item(opt)}
										</ContextMenu.Item>
									{/each}
								</Stack>
							{:else}
								<div class="text-center font-style-placeholder px-4 py-2">
									No options
								</div>
							{/if}
						</ContextMenu.SubContent>
					</ContextMenu.Sub>
				{:else}
					<ContextMenu.Item class="hover:bg-{option.theme || 'neutral'}-softest rounded">
						{@render item(option)}
					</ContextMenu.Item>
				{/if}

			{/each}
		</ContextMenu.Content>
	</ContextMenu.Portal>
</ContextMenu.Root>