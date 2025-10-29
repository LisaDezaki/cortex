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
	 * Modal Actions
	 * The following methods will open a modal with the designated props.
	 * Those modals will handle their own forms based on these props,
	 * but the initial form data can be overwritten from here.
	 */

	openModal(modalName, props) {

		switch(modalName) {
			case 'delete':
				modalActions.open('deleteFaction', { faction: this }); break;
			case 'rename':
				modalActions.open('renameFaction', { faction: this }); break;
			case 'setHeadquarters':
				modalActions.open('setHeadquarters', ...props); break;
			case 'member':
				modalActions.open('setFactionMember', { character: this, ...props }); break;
			case 'setBanner':
				modalActions.open('uploadMedia', {
					aspect: 'aspect-[3/1]',
					endpoint: this.routes.update,
					media: this.getBanner(),
					method: 'patch',
					reloadPageProps: ['faction.media', 'factions.media'],
					title: 'Upload banner for ' + this.name,
					type: 'banner',
				}); break;
			case 'setEmblem':
				modalActions.open('uploadMedia', {
					aspect: 'aspect-square',
					endpoint: this.routes.update,
					media: this.getEmblem(),
					method: 'patch',
					reloadPageProps: ['faction.media', 'factions.media'],
					title: 'Upload emblem for ' + this.name,
					type: 'emblem',
				}); break;
			default:
				console.log('FactionObject.openModal', modalName, props)
		}

	}
	

	addMember(opt) {
		console.log('FactionObject.addMember()', opt)
		this._update({
			members: [
				{ id: opt.id }
			]
		})
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

	// setHeadquarters() {
	// 	modalActions.open('selectLocation', {
	// 		endpoint: route('factions.update', { faction: this.slug }),
	// 		method: 'patch',
	// 		title: `Set ${this.name} Headquarters`
	// 	})
	// }



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

	updateMember(opt) {
		console.log('FactionObject.updateMember()', opt)
	}

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