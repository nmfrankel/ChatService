import storage from '$lib/store'

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

interface Users {
	user: User
	otherUser: User
}

export const userState = storage<Users>('userData', {
	user,
	otherUser
})
