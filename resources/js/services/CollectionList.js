import { router } from '@inertiajs/svelte'
import { route } from 'momentum-trail'

import { modalActions } from '@/stores/modalStore';
import CollectionObject from '@/services/CollectionObject'

export default class CollectionList {
	constructor(list, type) {
		Object.assign(this, {
			items: Array.isArray(list) ? list.map(i => new CollectionObject(i, type)) : [list],
			type: type,
			history: [], // Track changes for undo/redo
			filters: {}, // Store active filters
			sortOrder: null, // Current sort order
			routes: {
				store:	route('collections.store')
			}
		})
		this._saveToHistory(); // Save initial state to history
	}

	create(items) {
		console.log('CollectionList.create()', items)
		modalActions.open('createCollection', { type: this.type, items })
	}

	filter(query, filter) {
		console.log('CollectionList.filter()', query, filter)
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