import { writable } from 'svelte/store'

let user: User = {
		id: '1',
		first: 'Jason',
		last: 'Frinsk',
		phone: '+972534733971',
		email: 'nossonmfrankel@gmail.com',
		handle: 'nmfrankel'
	},
	otherUser: User = {
		id: '',
		first: 'Unknown',
		last: 'conversation',
		phone: '',
		email: '',
		handle: 'missing'
	}

export const userState = writable({
	user,
	otherUser
})
