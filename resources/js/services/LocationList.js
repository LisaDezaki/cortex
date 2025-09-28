import { router } from '@inertiajs/svelte'
import { route } from 'momentum-trail'

import { modalActions } from '@/stores/modalStore';
import LocationObject   from '@/services/LocationObject'

export default class LocationList {
	constructor(list) {
		Object.assign(this, {
			items: Array.isArray(list) ? list.map(i => new LocationObject(i)) : [list],
			history: [], // Track changes for undo/redo
			filters: {}, // Store active filters
			sortOrder: null, // Current sort order
			routes: {
				store:	route('locations.store')
			}
		})
		this._saveToHistory(); // Save initial state to history
	}

	create() {
		modalActions.open('createLocation')
	}

	filter(query, filter) {
		console.log('LocationList.filter()', query, filter)
	}

	getWorldMap() {
		return this.items.find(item => item.isWorldMap)
	}

	// History/Undo
	_saveToHistory() {
		this.history.push([...this.items]);
		// Keep only last 50 states to prevent memory issues
		if (this.history.length > 50) {
			this.history.shift();
		}
	}
}