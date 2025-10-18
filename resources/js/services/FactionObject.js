import { router } from '@inertiajs/svelte'
import { route } from 'momentum-trail'

import CharacterList from '@/services/CharacterList'
import LocationObject from '@/services/LocationObject'
import { modalActions } from '@/stores/modalStore';

export default class FactionObject {
	constructor(factionData) {
		Object.assign(this, factionData, {
			headquarters: factionData.headquarters ? new LocationObject(factionData.headquarters) : null,
			members: factionData.members ? new CharacterList(factionData.members) : null,
			routes: {
				show:    route('factions.show',    { faction: factionData.slug }),
				update:  route('factions.update',  { faction: factionData.slug }),
				destroy: route('factions.destroy', { faction: factionData.slug })
			}
		})
	}


	/**
	 * Modal methods
	 */
	
	addBanner() {
		modalActions.open('uploadMedia', {
			aspect: 'aspect-[3/1]',
			endpoint: this.routes.update,
			media: this.getBanner(),
			method: 'patch',
			reloadPageProps: ['faction.media', 'factions.media'],
			title: "Add banner to " + this.name,
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
			title: "Add emblem to " + this.name,
			type: 'emblem',
		})
	}

	addMember(char) {
		console.log('addMember()', char?.name)
	}

	addTag(tag) {
		console.log('addTag()', tag)
	}

	delete() {
		modalActions.open('deleteFaction', { faction: this })
	}

	rename() {
		modalActions.open('renameFaction', { faction: this })
	}

	setHeadquarters() {
		modalActions.open('selectLocation', {
			endpoint: route('factions.update', { faction: this.slug }),
			method: 'patch',
			title: `Set ${this.name} Headquarters`
		})
	}



	/**
	 * 	Media methods
	 */

	getBanner() {
		return this.media?.filter(m => m.type === 'banner')?.[0] || null
	}

	getEmblem() {
		return this.media?.filter(m => m.type === 'emblem')?.[0] || null
	}

	/**
	 * 	Update methods
	 */

	removeHeadquarters() {
		console.log('removeHeadquarters()')
	}

	removeMember(char) {
		console.log('removeMember()', char?.name)
	}

	star() {
		this._update({ starred: !Boolean(this.starred) })
	}


	/**
	 * 	HTTP methods
	 */

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