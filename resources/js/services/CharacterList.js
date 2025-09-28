import { router } from '@inertiajs/svelte'
import { route } from 'momentum-trail'

import { modalActions } from '@/stores/modalStore';
import CharacterObject from '@/services/CharacterObject'

export default class CharacterList {
	constructor(list) {
		Object.assign(this, {
			items: Array.isArray(list) ? list.map(i => new CharacterObject(i)) : [list],
			history: [], // Track changes for undo/redo
			filters: {
				query: '',
				filter: '',
				sort: 'name.asc',
				layout: 'grid'
			},
			routes: {
				store:	route('characters.store')
			}
		})
		this._saveToHistory(); // Save initial state to history
	}

	create() {
		modalActions.open('createCharacter')
	}

	filter() {
		console.log('CharacterList.filter()')
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