import { router } from '@inertiajs/svelte'
import { route } from 'momentum-trail'

import { modalActions } from '@/stores/modalStore';

export default class FactionObject {
	constructor(factionData) {
		Object.assign(this, factionData, {
			routes: {
				show:    route('factions.show',    { faction: factionData.slug }),
				update:  route('factions.update',  { faction: factionData.slug }),
				destroy: route('factions.destroy', { faction: factionData.slug })
			}
		})
	}
	
	addBanner() {
		modalActions.open('uploadMedia', {
			aspect: 'aspect-[3/1]',
			endpoint: this.routes.update,
			media: this.getBanner(),
			method: 'patch',
			reloadPageProps: ['faction.media', 'factions.media'],
			type: 'banner',
		})
	}

	addEmblem() {
		modalActions.open('uploadMedia', {
			aspect: 'aspect-square',
			endpoint: this.routes.update,
			media: this.getEmblem(),
			method: 'patch',
			reloadPageProps: ['faction.media', 'factions.media'],
			type: 'emblem',
		})
	}

	addMember(char) {
		console.log('addMember()', char?.name)
	}

	addTag(tag) {
		console.log('addTag()', tag)
	}

	// addToCollection(collection) {
	// 	console.log('addToCollection', collection.name)
	// }

	delete() {
		modalActions.open('deleteFaction', { faction: this })
	}

	getBanner() {
		return this.media?.filter(m => m.type === 'banner')?.[0] || null
	}

	getEmblem() {
		return this.media?.filter(m => m.type === 'emblem')?.[0] || null
	}

	removeHeadquarters() {
		console.log('removeHeadquarters()')
	}

	removeMember(char) {
		console.log('removeMember()', char?.name)
	}

	setHeadquarters(faction) {
		console.log('setFaction()', faction?.name)
	}

	star() {
		console.log('star()')
		// this._update({ starred: !Boolean(this.starred) })
	}

	_update(data) {
		router.patch(
			this.routes.update,
			data,
			{
				onFinish: (response) => {
					router.visit( router.page.url, { only: ['factions'] })
				}
			}
		)
	}
}