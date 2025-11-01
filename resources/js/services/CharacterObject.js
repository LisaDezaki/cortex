import { router } from '@inertiajs/svelte'
import { route } from 'momentum-trail'

import CharacterList from '@/services/CharacterList'
import FactionList from '@/services/FactionList'
import LocationObject from '@/services/LocationObject'
import { modalActions } from '@/stores/modalStore'

export default class CharacterObject {
    constructor(characterData) {
        Object.assign(this, characterData, {
			factions:		characterData.factions		? new FactionList(characterData.factions)		 		: null,
			location: 		characterData.mapData?.location ? new LocationObject(characterData.mapData.location) 	: null,
			relationships: 	characterData.relationships ? new CharacterList(characterData.relationships) 		: null,
			routes: {
				show:    route('characters.show',    { character: characterData.slug }),
				update:  route('characters.update',  { character: characterData.slug }),
				destroy: route('characters.destroy', { character: characterData.slug })
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
				modalActions.open('deleteCharacter', { character: this }); break;
			case 'rename':
				modalActions.open('renameCharacter', { character: this }); break;
			case 'location':
				modalActions.open('setLocation', ...props); break;
			case 'relationship':
				modalActions.open('setCharacterRelationship', { character: this, ...props }); break;
			case 'setBanner':
				modalActions.open('uploadMedia', {
					aspect: 'aspect-[3/1]',
					endpoint: this.routes.update,
					media: this.getBanner(),
					method: 'patch',
					reloadPageProps: ['character.media', 'characters.media'],
					title: 'Upload banner for ' + this.name,
					type: 'banner',
				}); break;
			case 'setPortrait':
				modalActions.open('uploadMedia', {
					aspect: 'aspect-square',
					endpoint: this.routes.update,
					media: this.getPortrait(),
					method: 'patch',
					reloadPageProps: ['character.media', 'characters.media'],
					title: 'Upload portrait for ' + this.name,
					type: 'portrait',
				}); break;
			default:
				console.log('CharacterObject.openModal', modalName, props)
		}

	}



	/**
	 * Helper methods
	 * The following methods can be used to fetch specific data from
	 * this character more easily.
	 */

	findFaction(id) {
		return this.factions.items?.find(f => f.id === id) || null
	}

	findRelationship(id) {
		return this.relationships.items?.find(r => r.id === id) || null
	}

	getBanner() {
		return this.media?.filter(m => m.type === 'banner')?.[0] || null
	}

	getPortrait() {
		return this.media?.filter(m => m.type === 'portrait')?.[0] || null
	}



	/**
	 * Update methods
	 * The following methods will directly update the database for this Character,
	 * by sending update requests to the server.
	 */

	star() {
		this._update({ starred: !Boolean(this.starred) })
	}

	setCustomField(id, value) {
		this._update({ custom_fields: [{ id, value }] })
	}

	//	One-to-one relationships

	setLocation(location_id) {
		this._update({ location_id })
	}

	unsetLocation() {
		this._update({ location_id: null })
	}

	//	One-to-many relationships

	addRelationship(related, role, related_role) {
		console.log(related, role, related_role)
	}

	removeRelationship(id) {
		console.log('remove specific relationship with id: ', id)
	}

	clearRelationships() {
		console.log('clear all relationships from this character')
	}

	//	Many-to-many relationships

	addFaction(id) {
		this._update({ factions: [{ id }] })
	}

	removeFaction(id) {
		this._update({ faction_id: null })
	}

	syncFactions(opt, index) {
		let factionIds = this.factions.items?.map((f,i) => {
			return { id: i !== index ? f.id : opt.id }
		})
		this._update({ factions: factionIds })
	}



	/**
	 * HTTP methods
	 * The following methods are shortcuts for submitting http requests to the server,
	 * as long as they follow the standard convention.
	 */

	_store(data) {
		router.post(
			this.routes.store, data, {
				onFinish: () => router.visit( router.page.url, { only: ['characters'] })
			}
		)
	}

	_update(data) {
		router.patch(
			this.routes.update, data, {
				onFinish: () => router.visit( router.page.url, { only: ['characters'] })
			}
		)
	}

	_destroy(data) {
		router.destroy(
			this.routes.destroy, data, {
				onFinish: () => router.visit( router.page.url, { only: ['characters'] })
			}
		)
	}
}